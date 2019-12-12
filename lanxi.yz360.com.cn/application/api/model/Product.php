<?php

namespace app\api\model;

use think\Model;

class Product extends Model
{

    // 表名
    protected $name = 'product';
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
  

}
