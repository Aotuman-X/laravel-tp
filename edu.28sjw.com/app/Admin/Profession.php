<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    //定义关联的表
    protected $table = 'profession';
    //定义与protype的关联模型,方法hasOne中三个参数分别是，要关联的表模型（Protype），关联表（Protype）中的关联字段，自身表（Profession）中的关联字段
    public function protype(){
    	return $this -> hasOne('App\Admin\Protype','id','protype_id');
    }
}
