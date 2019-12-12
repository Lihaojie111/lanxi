<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use app\admin\model\User;
use app\admin\model\Admin;
use app\admin\model\product\Index;
use app\admin\model\order\Index as Order;
use app\common\model\MoneyLog;
use app\admin\model\technician\Index as Tech;
use app\admin\model\msg\Index as msg;
use app\admin\model\card\Index as card;
use app\admin\model\service\Index as service;

/**
 * 控制台
 *
 * @icon fa fa-dashboard
 * @remark 用于展示当前系统中的统计数据、统计报表及重要实时数据
 */
class Dashboard extends Backend
{

    /**
     * 查看
     */
    public function index()
    {
        //会员数量
        $userCount = User::count();
        //产品数量
        $proCount = Index::where('is_del', 0)->count();
        //订单数量
        $orderCount = Order::where('is_del', 0)->count();
        //总金额流水
        $moneyCount = MoneyLog::sum('money');
        $admin = new Admin();
        $adminInfo = $admin
            ->where('id', session('admin')['id'])
            ->field('nickname,logintime,loginIp')
            ->find();
        $tech = new Tech();
        $techNum = $tech
            ->where('is_del', 0)
            ->where('status', 1)
            ->count();
        $techInfo= $tech
            ->where('is_del', 0)
            ->where('status', 1)
            ->order('onclicks desc')
            ->field('name,img')
            ->find();
        $msg = new msg();
        $msgCount = $msg
            ->where('is_del', 0)
            ->count();
        $msgNum = $msg
            ->where('is_del', 0)
            ->where('status', 1)
            ->count();
        $card = new card();
        $cardNum = $card
            ->where('is_del', 0)
            ->where('status', 1)
            ->count();
        $service = new service();
        $serviceCount = $service
            ->where('is_del', 0)
            ->count();
        $serviceNum = $service
            ->where('is_del', 0)
            ->where('status', 1)
            ->count();
        $orderInfo=Order::where('is_del',0)->alias('o')->join('__USER__ u','u.id=o.uid','LEFT')->field('o.*,u.username,avatar')->limit(7)->order('id desc')->select();
        $msgInfo=$msg->where('is_del',0)->limit(7)->order('id desc')->select();
        $this->view->assign([
            'userCount'     => $userCount,
            'proCount'      => $proCount,
            'orderCount'    => $orderCount,
            'moneyCount'    => $moneyCount,
            'adminInfo'     => $adminInfo,
            'techNum'       => $techNum,
            'msgCount'      => $msgCount,
            'msgNum'        => $msgNum,
            'cardNum'       => $cardNum,
            'serviceCount'  => $serviceCount,
            'serviceNum'    => $serviceNum,
            'techInfo'      =>$techInfo,
            'orderInfo'     =>$orderInfo,
            'msgInfo'       =>$msgInfo
        ]);
        return $this->view->fetch();
    }
}
