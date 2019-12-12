<?php

namespace app\admin\model\card;

use think\Model;


class Cat extends Model
{

    

    

    // 表名
    protected $name = 'card_cat';
    
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
    //获取分类名称
    static function getList(){
        $where['is_del']=0;
        $where['status']=1;
        return self::where($where)->field('id,name')->select();
    }

}
