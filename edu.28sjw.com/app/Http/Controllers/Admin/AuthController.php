<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//引入Input,通过input类型判断是展示视图还是添加数据
use Input;
use App\Admin\Auth;
use DB;//引入DB不适用Auth模型是因为DB可以起别名对数据表
class AuthController extends Controller
{
    //列表
    public function index(){
    	//查询数据
    	//select t1.*,t2.auth_name as parent_name from auth as t1 left join auth as t2 on t1.pid = t2.id
    	$data = DB::table('auth as t1') -> select('t1.*','t2.auth_name as parent_name') -> leftJoin('auth as t2','t1.pid','=','t2.id') -> get();
    	return view('admin.auth.index',compact('data'));
    }

    //添加
    public function add(){
    	//判断请求类型
    	if(Input::method() == 'POST'){
    		//处理数据，可以在此进行后台的验证
	    	//接收数据进入数据表
	    	$data = Input::except('_token');
	    	$result = Auth::insert($data);
	    	//框架不支持响应bool值，转化返回形式
	    	return $result ? '1' : '0';
    	}else{
    		//查询父级权限
    		$parents = Auth::where('pid','=','0') -> get();
    		//展示试图
    		return view('admin.auth.add',compact('parents'));
    	}
    }
}
