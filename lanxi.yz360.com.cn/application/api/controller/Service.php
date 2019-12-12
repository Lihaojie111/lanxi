<?php

namespace app\api\controller;
use app\common\controller\Api;
use app\api\model\Servicecat;
use app\api\model\Service as Services;
use app\api\model\Cardcat;
use app\api\model\Card;
use app\api\model\Productcat;
use app\api\model\Product;
/**
 * 服务接口
 */
class Service extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
     /**
     * 服务分类
     *
     */
    public function cat()
    {
        $servicecat = new Servicecat();
        $where['status']=1;
        $where['is_del']=0;
        $list = $servicecat->where($where)->field('id,name')->select();
        if(!empty($list)){
            $this->success("成功", $list);
        }else{
            $this->error('没有数据');
        }
    }
    /**
     * 服务列表
     *
     */
    public function serviceDetail()
    {
        $services = new Services();
        $id=$this->request->request('id');
        $where['status']=1;
        $where['is_del']=0;
        $where['cat_id']=$id;
        $list = $services->where($where)->field('id,name,img,times,price')->order('id desc')->select();
        if(!empty($list)){
            $this->success("成功", $list);
        }else{
            $this->error('没有数据');
        }
    }
     /**
     * 服务详情
     *
     */
    public function detailService()
    {
        $services = new Services();
        $id=$this->request->request('id');
        $where['id']=$id;
        $list = $services->where($where)->find();
        if(!empty($list)){
            $this->success("成功", $list);
        }else{
            $this->error('没有数据');
        }
    }
     /**
     * 卡片分类
     *
     */
    public function cardCat()
    {
        $cardcat = new Cardcat();
        $where['status']=1;
        $where['is_del']=0;
        $list = $cardcat->where($where)->field('id,name')->order('id desc')->select();
        if(!empty($list)){
            $this->success("成功", $list);
        }else{
            $this->error('没有数据');
        }
    }
     /**
     * 卡片列表
     *
     */
    public function cardList()
    {
        $card = new Card();
        $id=$this->request->request('id');
        if($id>0){
            $where['cat_id']=$id;
        }
        $where['status']=1;
        $where['is_del']=0;
        $list = $card->where($where)->field('id,name,img,price')->order('price asc')->select();
        if(!empty($list)){
            $this->success("成功", $list);
        }else{
            $this->error('没有数据');
        }
    }
     /**
     * 产品分类
     *
     */
    public function productCat()
    {
        $productcat = new Productcat();
        $where['status']=1;
        $where['is_del']=0;
        $list = $productcat->where($where)->field('id,name')->order('id desc')->select();
        if(!empty($list)){
            $this->success("成功", $list);
        }else{
            $this->error('没有数据');
        }
    }
     /**
     * 产品列表
     *
     */
    public function productList()
    {
        $product = new Product();
        $id=$this->request->request('id');
        $page=$this->request->request('page',1);
        if($id>0){
            $where['cat_id']=$id;
        }
        $where['status']=1;
        $where['is_del']=0;
        $list = $product->where($where)->field('id,name,img,price')->page($page,10)->order('id desc')->select();
        if(!empty($list)){
            $this->success("成功", $list);
        }else{
            $this->error('没有数据');
        }
    }
     /**
     * 产品详情
     *
     */
    public function detail()
    {
        $product = new Product();
        $id=$this->request->request('id');
        $list = $product->where('id',$id)->field('id,name,img,price,detail,introduce')->find();
        $list['detail']=preg_replace("/<p.*?>|<\/p>/is","", $list['detail']);
        if(!empty($list)){
            $this->success("成功", $list);
        }else{
            $this->error('没有数据');
        }
    }
}
