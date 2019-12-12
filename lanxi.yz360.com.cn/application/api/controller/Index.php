<?php

namespace app\api\controller;

use app\common\controller\Api;
use app\api\model\Lunbo;
use app\api\model\Servicecat;
use app\api\model\Technician;
use app\api\model\Product;
use app\api\model\Msg;
use think\Config;
/**
 * 首页接口
 */
class Index extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
     * 首页lunbo
     *
     */
    public function lunbo()
    {
        $type=$this->request->request('type');
        $lunbo = new Lunbo();
        $where['status']=1;
        $where['is_del']=0;
        $where['type']=$type;
        $list = $lunbo->where($where)->order('id desc')->select();
        if(!empty($list)){
            $this->success("成功", $list);
        }else{
            $this->error('没有数据');
        }
    }
     /**
     * 首页服务展示
     *
     */
    public function servicecat()
    {
        $servicecat = new Servicecat();
        $where['status']=1;
        $where['is_del']=0;
        $list = $servicecat->where($where)->field('id,name,img')->order('id desc')->select();
        if(!empty($list)){
            $this->success("成功", $list);
        }else{
            $this->error('没有数据');
        }
    }
    /**
     * 皮肤管理师
     *
     */
    public function technician()
    {
        $technician = new Technician();
        $where['status']=1;
        $where['is_del']=0;
        $list = $technician->where($where)->field('id,name,img')->order('onclicks desc')->limit(4)->select();
        if(!empty($list)){
            $this->success("成功", $list);
        }else{
            $this->error('没有数据');
        }
    }
    /**
     * 首页产品展示
     *
     */
    public function product()
    {
        $product = new Product();
        $where['status']=1;
        $where['is_del']=0;
        $where['is_index']=1;
        $list = $product->where($where)->field('id,name,img,introduce')->order('id desc')->limit(4)->select();
        if(!empty($list)){
            $this->success("成功", $list);
        }else{
            $this->error('没有数据');
        }
    }
     /**
     * 首页最新消息
     *
     */
    public function news()
    {
        $msg = new Msg();
        $where['status']=1;
        $where['is_del']=0;
        $list = $msg->where($where)->field('id,title,img,ctime,des')->order('id desc')->limit(3)->select();
        if(!empty($list)){
            $this->success("成功", $list);
        }else{
            $this->error('没有数据');
        }
    }
     /**
     * 首页最新消息详情
     */
    public function newsDetail()
    {
        $msg = new Msg();
        $id = $this->request->request('id');
        $info = $msg->where('id',$id)->field('content,title,ctime,des')->find();
        if(!empty($info)){
            $info['content']= preg_replace("/<p.*?>|<\/p>/is","", $info['content']);
            $this->success("成功", $info);
        }else{
            $this->error('没有数据');
        }
    }
    /**
     * 公司简介
     *
     */
    public function detail()
    {
        $list=[];
        $list['company_detail']=preg_replace("/<p.*?>|<\/p>/is","", Config::get('site.company_detail'));
        $list['sign']=Config::get('site.sign');
        $list['phone']=Config::get('site.phone');
        $list['addr']=Config::get('site.addr');
        $list['date']=Config::get('site.data');
        if(!empty($list)){
            $this->success("成功", $list);
        }else{
            $this->error('没有数据');
        }
    }
}
