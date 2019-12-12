<?php

namespace app\admin\model\product;

use think\Model;


class Index extends Model
{

    

    

    // 表名
    protected $name = 'product';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [

    ];
    

    public function cat(){
        return $this->hasOne('cat','id','cat_id')->field('id,name');
    }







}
