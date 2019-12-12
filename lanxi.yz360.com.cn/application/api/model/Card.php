<?php

namespace app\api\model;

use think\Model;

class Card extends Model
{

    // 表名
    protected $name = 'card';
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
  

}
