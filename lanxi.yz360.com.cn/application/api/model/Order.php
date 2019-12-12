<?php

namespace app\api\model;

use think\Model;

class Order extends Model
{

    // 表名
    protected $name = 'order';
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
  

}
