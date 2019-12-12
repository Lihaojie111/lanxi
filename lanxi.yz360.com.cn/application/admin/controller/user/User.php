<?php

namespace app\admin\controller\user;

use app\common\controller\Backend;
use think\Db;
use app\common\model\MoneyLog;
use app\common\model\ScoreLog;
use think\Config;
use app\admin\model\card\Index as Card;
use app\admin\model\order\Index as Order;
/**
 * 会员管理
 *
 * @icon fa fa-user
 */
class User extends Backend
{
    protected $relationSearch = true;
    /**
     * @var \app\admin\model\User
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('User');
    }
    /**
     * 查看
     */
    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()){
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                ->with('group')
                ->where($where)
                ->order($sort, $order)
                ->count();
            $list = $this->model
                ->with('group')
                ->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();
            foreach ($list as $k => $v) {
                $v->hidden(['password', 'salt']);
            }
            $result = array("total" => $total, "rows" => $list);
            return json($result);
        }
        return $this->view->fetch();
    }
    /**
     * 编辑
     */
    public function edit($ids = NULL)
    {
        $row = $this->model->get($ids);
        if (!$row)
            $this->error(__('No Results were found'));
        $this->view->assign('groupList', build_select('row[group_id]', ['class' => 'form-control selectpicker']));
        return parent::edit($ids);
    }
    /**
     * 删除
     */
    public function del($ids = "")
    {
        if ($ids) {
            $pk = $this->model->getPk();
            $adminIds = $this->getDataLimitAdminIds();
            if (is_array($adminIds)) {
                $this->model->where($this->dataLimitField, 'in', $adminIds);
            }
            $list = $this->model->where($pk, 'in', $ids)->select();
            $count = 0;
            Db::startTrans();
            try {
                foreach ($list as $k => $v) {
                    $count += $v->delete();
                   Order::where('uid',$v['id'])->delete();
                   MoneyLog::where('user_id',$v['id'])->delete();
                   ScoreLog::where('user_id',$v['id'])->delete();
                }
                Db::commit();
            } catch (PDOException $e) {
                Db::rollback();
                $this->error($e->getMessage());
            } catch (Exception $e) {
                Db::rollback();
                $this->error($e->getMessage());
            }
            if ($count) {
                $this->success();
            } else {
                $this->error();
            }
        }
        $this->error(__('Parameter %s can not be empty', 'ids'));
    }
    /**
     * 充值
     */
    public function rechage($ids = NULL)
    {
        $id = $this->request->param('ids');
        $card = new Card();
        $where['cat_id'] = 1;
        $where['status'] = 1;
        $where['is_del'] = 0;
        $list = $card->where($where)->field('id,price,shiji')->order('price asc')->select();
        $this->assign('list', $list);
        $this->assign('id', $id);
        return $this->view->fetch();
    }
    /**
     * 消费
     */
    public function consume($ids = NULL)
    {
        $id = $this->request->param('ids');
        $score = $this->model->where('id', $id)->value('score');
        $this->assign('score', $score);
        $this->assign('id', $id);
        return $this->view->fetch();
    }
    /**
     * 提现
     */
    public function withdrawal($ids = NULL)
    {
        $id = $this->request->param('ids');
        $score = $this->model->where('id', $id)->value('score');
        $this->assign('score', $score);
        $this->assign('id', $id);
        return $this->view->fetch();
    }
    /**
     * 一级盟友
     */
    public function first($ids = NULL)
    {
        $id = $this->request->param('ids');
        $info = $this->model->where('first_leader', $ids)->field('username,avatar')->select();
        $this->assign('info', $info);
        return $this->view->fetch();
    }
    /**
     * 二级盟友
     */
    public function second($ids = NULL)
    {
        $id = $this->request->param('ids');
        $info = $this->model->where('second_leader', $ids)->field('username,avatar')->select();
        $this->assign('info', $info);
        return $this->view->fetch();
    }
    /**
     * 三级盟友
     */
    public function third($ids = NULL)
    {
        $id = $this->request->param('ids');
        $info = $this->model->where('third_leader', $ids)->field('username,avatar')->select();
        $this->assign('info', $info);
        return $this->view->fetch();
    }
    /**
     * 给用户充值
     */
    public function addMoney()
    {
        if ($this->request->isPost()) {
            $card = new Card();
            $ScoreLog = new ScoreLog();
            $MoneyLog = new MoneyLog();
            $money = input('money');

            $id = input('id');
            $cid = input('cid');
            if ($cid) {
                $info = $card->where('id', $cid)->field('shiji,price')->find();
            }
            if ($money) {
                $info['price'] = $money;
                $info['shiji'] = $money;
            }
            $score = Config::get('site.score') * $info['price'];
            $MoneyLog->data([
                'user_id' => $id,
                'money' => $info['shiji'],
                'cmoney' => $info['price'],
                'zmoney' => $info['shiji'] - $info['price'],
                'type' => 1,
                'memo' => '充值',
            ]);
            $ScoreLog->data([
                'user_id' => $id,
                'score' => $score,
                'type' => 1,
                'memo' => '充值奖励',
            ]);
            Db::startTrans();
            $res = $this->model->where('id', $id)->setInc('money', $info['shiji']);
            $res1 = $this->model->where('id', $id)->setInc('score', $score);
            $addMoney = $MoneyLog->save();
            $addScore = $ScoreLog->save();
            if ($res && $addMoney && $addScore && $res1) {
                Db::commit();
                // $this->success('充值成功');
                return json(['code' => 1]);
            } else {
                Db::rollback();
                // $this->error('充值失败');
                return json(['code' => 0, 'msg' => '充值失败']);
            }
        }
    }
    /**
     * 给用户扣款
     */
    public function saveMoney()
    {
        if ($this->request->isPost()) {
            $MoneyLog = new MoneyLog();
            $ScoreLog = new ScoreLog();
            $money = input('money');
            $id = input('id');
            $score = input('score');
            Db::startTrans();
            if ($score) {
                $money = $money - Config::get('site.score') * $score;
                $saveScore = $this->model->where('id', $id)->setDec('score', $score);
                $ScoreLog->data([
                    'user_id' => $id,
                    'score' => $score,
                    'type' => 2,
                    'memo' => '消费抵扣',
                ]);
                $addScore = $ScoreLog->save();
            } else {
                $saveScore = $addScore = 1;
            }
            $umoney = $this->model->where('id', $id)->value('money');
            if ($money > $umoney) {
                return json(['code' => 0, 'msg' => '余额不足，请充值']);
            }
            $res = $this->model->where('id', $id)->setDec('money', $money);
            $MoneyLog->data([
                'user_id'  =>  $id,
                'money' =>  $money,
                'type' => 2,
                'memo' => '消费',
            ]);
            $addMoney = $MoneyLog->save();
            if ($res && $addMoney && $saveScore && $addScore) {
                Db::commit();
                return json(['code' => 1]);
            } else {
                Db::rollback();
                return json(['code' => 0, 'msg' => '扣款失败']);
            }
        }
    }
    /**
     * 给用户提现
     */
    public function saveScore()
    {
        if ($this->request->isPost()) {
            $ScoreLog = new ScoreLog();
            $id = input('id');
            $score = input('score');
            Db::startTrans();
            $money = Config::get('site.score') * $score;
            $saveScore = $this->model->where('id',$id)->setDec('score',$score);
            $ScoreLog->data([
                'user_id' => $id,
                'score' => $score,
                'type' => 2,
                'memo' => '积分提现',
            ]);
            $addScore = $ScoreLog->save();
            if ($saveScore && $addScore) {
                Db::commit();
                $this->success();
            } else {
                Db::rollback();
                return json(['code' => 0, 'msg' => '积分不足']);
            }
        }
    }
    /**
     * 用户余额历史记录
     */
    public function moneylog($ids = NULL)
    {
        $MoneyLog = new MoneyLog();
        $id = $this->request->param('ids');
        $info = $MoneyLog->where('user_id', $ids)->order('id desc')->select();
        $this->assign('info', $info);
        return $this->view->fetch();
    }
    /**
     * 用户积分历史记录
     */
    public function scorelog($ids = NULL)
    {
        $Scorelog = new ScoreLog();
        $id = $this->request->param('ids');
        $info = $Scorelog->where('user_id', $ids)->order('id desc')->select();
        $this->assign('info', $info);
        return $this->view->fetch();
    }
}
