<?php

namespace app\api\controller;
use app\common\controller\Api;
use app\api\model\Technician;
use app\api\model\Service;
use app\api\model\Order as orders;
use think\Db;
/**
 * 预约接口
 */
class Order extends Api
{
    protected $noNeedLogin = [''];
    protected $noNeedRight = ['*'];
    /**
     * 技师接口
     *
     */
    public function technician(){
        $technician = new Technician();
        $where['status']=1;
        $where['is_del']=0;
        $list = $technician->where($where)->field('id,name,img')->select();
        if(!empty($list)){
            $this->success("成功", $list);
        }else{
            $this->error('没有数据');
        }
    }
     /**
     * 服务接口
     *
     */
    public function service(){
        $service = new Service();
        $where['status']=1;
        $where['is_del']=0;
        $list = $service->where($where)->field('id,name')->order('id desc')->select();
        if(!empty($list)){
            $this->success("成功", $list);
        }else{
            $this->error('没有数据');
        }
    }
    /**
     * 预约
     *
     */
    public function order(){
        $orders = new orders();
        $technician = new Technician();
        $userinfo = $this->auth->getUserinfo();
        $uid = $userinfo['id'];
        $techname = $this->request->request("techname");
        $techimg=$technician->where('name',$techname)->value('img');
        $times = $this->request->request("times");
        $servicename = $this->request->request("servicename");
        $orders->data([
            'uid'=>$uid,
            'techname'=>$techname,
            'servicename' => $servicename,
            'techimg'=>$techimg,
            'times'=>$times,
            'ctime'=>time(),
            'status'=>1,
        ]);
        Db::startTrans();
        $addOrder=$orders->allowField(true)->save();
        $saveT=$technician->where('name',$techname)->setInc('onclicks',1);
        if($addOrder&&$saveT){
            Db::commit();
            $this->success("成功");
        }else{
            Db::rollback();
            $this->error('失败');
        }
       
    }
}
