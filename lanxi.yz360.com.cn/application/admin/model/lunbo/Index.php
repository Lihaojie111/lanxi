<?php

namespace app\admin\model\lunbo;

use think\Model;


class Index extends Model
{

    

    

    // 表名
    protected $name = 'lunbo';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [

    ];
    //获取分类列表
    public function getList(){
        return  [
          ['id'=>1,'name'=>'轮播图'],
          ['id'=>2,'name'=>'店铺推荐'],
        ];
    }
    //获取分类
    public function getType($value){
        return $value==1?'轮播图':'店铺推荐';
    }
    
    public function service(){
        return $this->hasOne('service','id','service_id')->field('id,name');
    }






}
