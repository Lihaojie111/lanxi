<?php

namespace app\admin\model\service;

use think\Model;


class Index extends Model
{

    

    

    // 表名
    protected $name = 'service';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'ctime_text'
    ];
    

    



    public function getCtimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['ctime']) ? $data['ctime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setCtimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }
    public function cat(){
        return $this->hasOne('cat','id','cat_id')->field('id,name');
    }
   //获取服务名称
   static function getList(){
    $where['is_del']=0;
    $where['status']=1;
    return self::where($where)->field('id,name')->select();
}
}
