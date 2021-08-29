<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //填表方法
        Schema::create('manager',function(Blueprint $table){
            //设计字段
            $table -> increments('id');//主键
            $table -> string('username',20) -> notNull();//用户名，长度20的varchar，不能为空
            $table -> string('password') -> notNull();//密码，varchar(255)，不能为空
            $table -> enum('gender',[1,2,3]) -> notNull() -> default('1');//性别，1是男，2是女，3保密，默认为1
            $table -> string('mobile',11);//手机号
            $table -> string('email',50);//邮箱
            $table -> tinyInteger('role_id');//角色表中的主键id
            $table -> timestamps();//created_at和updated_at时间字段系统自己创建
            $table -> rememberToken();//实现记住登陆状态字段，用于存储token
            $table -> enum('status',[1,2]) -> notNUll() -> default('2');//账号状态，1启用，2禁用
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //删表方法
        Schema::dropIfExists('manager');
    }
}
