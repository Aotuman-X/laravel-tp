<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //定义关联的表,自增是id不用设置，有时间戳不用禁用，所以只需设置关联的表
    protected $table = 'member';
}
