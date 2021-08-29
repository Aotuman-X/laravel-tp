<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//引入模型
use App\Admin\Manager;

class ManagerController extends Controller
{
    //管理员列表操作
    public function index(){
    	//查询数据，通过引入的模型中的方法查询数据方便使用，查询数据还可以使用Db方法
    	//manager有all和get两种方法，all中间不能插入其他参数
    	$data = Manager::get();
    	//展示视图,使用compact方法携带查询到的数据返回视图
    	return view('admin.manager.index',compact('data'));
    }
}
