<?php

namespace app\api\controller;

use app\common\controller\Api;
use app\api\model\Order;
use think\Config;
use app\common\model\User as Users;
use wx\WxBizDataCrypt;
use app\common\model\MoneyLog;
use app\common\model\ScoreLog;

/**
 * 会员接口
 */
class User extends Api
{
    protected $noNeedLogin = ['login', 'getmobile', 'mobilelogin', 'register', 'resetpwd', 'changeemail', 'changemobile', 'third','arrayToXml'];
    protected $noNeedRight = '*';

    public function _initialize()
    {
        $this->appid = Config::get('site.AppID');
        $this->appsecret = Config::get('site.AppSecret');
        parent::_initialize();
    }
     /**
     * 是否还在登录
     * 参数token值
     */
    public function islogin()
    {
        $userinfo = $this->auth->getUserinfo();
        if (is_array($userinfo)) {
            $this->success();
        } else {
            $this->error($this->auth->getError());
        }
    }
    /**
     * 会员中心
     */
    public function index()
    {
        $this->success('', ['welcome' => $this->auth->nickname]);
    }
    /**
     * 获取用户的信息
     *
     * @param string $appId  小程序appid
     * @param string $appSecret 小程序密匙
     */
    public function login()
    {
        $code = $this->request->request('code');
        if (empty($code)) {
            $this->error($this->auth->getError('参数错误'));
        }
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=" . $this->appid . "&secret=" . $this->appsecret . "&js_code=" . $code . "&grant_type=authorization_code";
        $apiData = file_get_contents($url);
        $json_sessionKey = json_decode($apiData);
        $openid = $json_sessionKey->openid;
        $ret = $this->auth->login($openid, 1);
        if ($ret) {

            $data = ['userinfo' => $this->auth->getUserinfo()];
            $this->success("成功", $data);
        } else {
            $this->error($this->auth->getError());
        }
    }
    /**
     * 获取手机号
     *
     * @param string $appId  小程序appid
     * @param string $appSecret 小程序密匙
     */
    public function getmobile()
    {
        $code = $this->request->request('code');
        $encryptedData = $this->request->request('encryptedData');
        $iv = $this->request->request('iv');
        if (empty($code) || empty($encryptedData) || empty($iv)) {
            $this->error($this->auth->getError('参数错误'));
        }
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=" . $this->appid . "&secret=" . $this->appsecret . "&js_code=" . $code . "&grant_type=authorization_code";
        $apiData = file_get_contents($url);
        $json_sessionKey = json_decode($apiData);
        $sessionKey = $json_sessionKey->session_key;
        $openid = $json_sessionKey->openid;
        $info =  new WxBizDataCrypt($this->appid, $sessionKey);
        $errCode = $info->decryptData($encryptedData, $iv, $data);
        if ($errCode == 0) {
            $phone = json_decode($data)->phoneNumber;
            $users = new Users;
            $res = $users->where('wxopenid', $openid)->find();
            if ($res['mobile'] == '') {
                $saveUser = $users->where('id',$res['id'])->update(['mobile'=>$phone]);
                if ($saveUser) {
                    $this->success(__('Logged in successful'), $phone);
                } else {
                    $this->error('获取手机号失败');
                }
            }
        } else {
            $this->error('没有获取到手机号');
        }
    }
    /**
     * 注册
     *
     * @param string $nickname 用户名
     * @param string $avatar 头像
     * @param string $gender 性别
     */
    public function register()
    {
        $code = $this->request->request('code');
        $username = $this->request->request('nickname');
        $avatar = $this->request->request('avatar');
        $gender = $this->request->request('gender');
        if (empty($code)) {
            $this->error($this->auth->getError('参数错误'));
        }
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=" . $this->appid . "&secret=" . $this->appsecret . "&js_code=" . $code . "&grant_type=authorization_code";
        $apiData = file_get_contents($url);
        $json_sessionKey = json_decode($apiData);
        $openid = $json_sessionKey->openid;
        $ret = $this->auth->register($openid, $username, $avatar, $gender, []);
        if ($ret) {
            $data = ['userinfo' => $this->auth->getUserinfo()];
            $this->success(__('Sign up successful'), $data);
        } else {
            $this->error($this->auth->getError());
        }
    }
    /**
     * 我的预约
     */
    public function myOrder()
    {
        $userinfo = $this->auth->getUserinfo();
        $page = $this->request->request('page', 1);
        $uid = $userinfo['id'];
        $order = new Order();
        $list = $order->where('uid', $uid)->page($page, 10)->order('id desc')->select();
        $li_data = $order->where('uid', $uid)->count();
        $ret = [
                    'sumNum' => $li_data,
                    'data'   => $list,
                    ];
        if (!empty($ret)) {
            $this->success("成功", $ret);  
        } else {
            $this->error('没有数据');
        }
    }

    // public function myOrder()
    // {
    //     $userinfo = $this->auth->getUserinfo();
    //     // $page = $this->request->request('page', 1);
    //     $uid = $userinfo['id'];
    //     $order = new Order();
    //     $li_data = $order->where('uid', $uid)->count();
    
    //     $list = $order->where('uid', $uid)->select();
    //     // $array = [];
    //     // foreach($list as $k=>$v){
    //     //         $array[$k][] = $v['id']; 
    //     // }
    //     $ret = [
    //         'sumNum' => $li_data,
    //         'data'   => $list,
    //         ];
    //     if (!empty($ret)) {
    //         $this->success("成功", $ret);
    //     } else {
    //         $this->error('没有数据');
    //     }
    // }

    /**
     * 取消预约
     */
    public function orderSave()
    {
        $order = new Order();
        $id = $this->request->request('id');
        $res=$order->allowField(true)->save([
            'status'  => 0,
        ],['id' => $id]);
        if ($res) {
            $this->success("成功");
        } else {
            $this->error('失败');
        }
    }
    
    /**
     * 我的余额历史记录
     */
    public function moneyLog()
    {
        $userinfo = $this->auth->getUserinfo();
        $page = $this->request->request('page', 1);
        $uid = $userinfo['id'];
        $moneyLog = new MoneyLog();
        $pagecount = $moneyLog->where('user_id', $uid)->count();
        $list = $moneyLog->where('user_id', $uid)->page($page, 15)->field('money,type,memo,ctime')->order('id desc')->select();
        $ret = [
            'sumNum' => $pagecount,
            'data'   => $list,
            ];
        if (!empty($ret)) {
            $this->success("成功", $ret);
        } else {
            $this->error('没有数据');
        }
    }
    /**
     * 我的积分历史记录
     */
    public function scoreLog()
    {
        $userinfo = $this->auth->getUserinfo();
        $page = $this->request->request('page', 1);
        $uid = $userinfo['id'];
        $scoreLog = new ScoreLog();
        $list = $scoreLog->where('user_id', $uid)->page($page, 15)->field('score,memo,type,ctime')->order('id desc')->select();
        $pagecount = $scoreLog->where('user_id', $uid)->count();
        $ret = [
            'sumNum' => $pagecount,
            'data'   => $list,
            ];
        if (!empty($ret)) {
            $this->success("成功", $ret);
        } else {
            $this->error('没有数据');
        }
    }
    /**
     * 我的盟友
     */
    public function allyList()
    {
        $userinfo = $this->auth->getUserinfo();
        $type = $this->request->request('type', 1);
        // $page = $this->request->request('page', 1);
        $uid = $userinfo['id'];
        $users = new Users();
        if ($type == 1) {
            $where['first_leader'] = $uid;
        } elseif ($type == 2) {
            $where['second_leader'] = $uid;
        } else {
            $where['third_leader'] = $uid;
        }
        $pagecount= $users->where($where)->count();
        // $list = $users->where($where)->page($page, 10)->field('id,username,avatar')->select();
        $list = $users->where($where)->field('id,username,avatar')->select();
        $ret = [
            'sumNum' => $pagecount,
            'data'   => $list,
            ];
        if (!empty($ret)) {
            $this->success("成功", $ret);
        } else {
            $this->error('没有数据');
        }
    }
    /**
     * 盟友个数
     */
    public function allyNum()
    {
        $userinfo = $this->auth->getUserinfo();
        $uid = $userinfo['id'];
        $users = new Users();
        $list['total'] = $users->where('first_leader', $uid)->whereOr('second_leader', $uid)->whereOr('third_leader', $uid)->count();
        $list['first_leader'] = $users->where('first_leader', $uid)->count();
        $list['second_leader'] = $users->where('second_leader', $uid)->count();
        $list['third_leader'] = $users->where('third_leader', $uid)->count();
        if (!empty($list)) {
            $this->success("成功", $list);
        } else {
            $this->error('没有数据');
        }
    }
    /**
     * 添加盟友
     */
    public function allyAdd()
    {
        $userinfo = $this->auth->getUserinfo();
        $uid = $userinfo['id'];
        $users = new Users();
        $mobile = $this->request->request('mobile');
        $uinfo=$users->where('id',$uid)->field('first_leader,is_num')->find();
        $uids=$users->where('first_leader',$uid)->whereOr('second_leader',$uid)->whereOr('third_leader',$uid)->column('id');
        if($uinfo['is_num']==1){
            $this->error('失败');
        }
        $info=$users->where('mobile',$mobile)->field('id,first_leader,second_leader,third_leader')->find();
        if(in_array($info['id'],$uids)){
            $this->error('该用户已是盟友请勿重复添加！');
        }
        if(!empty($info)&&$uid!=$info['id']&&$info['third_leader']!=$uid&&$info['first_leader']!=$uid&&$info['second_leader']!=$uid){
            $save=$users->where('id',$uid)->update(['first_leader'=>$info['id'],'second_leader'=>$info['first_leader'],'third_leader'=>$info['second_leader']]);
            if($save){
                $users->where('id',$uid)->update(['is_num'=>1]);
                $this->success("成功",1);
            }else{
                $this->error('失败');
            }
        }elseif($uid==$info['id']){
            $this->error('盟友不能是自己请重新输入！');
        }else{
            $this->error('该盟友未注册！');
        }
    }
  
}
