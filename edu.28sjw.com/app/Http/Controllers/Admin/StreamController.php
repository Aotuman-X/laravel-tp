<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//引入模型
use App\Admin\Stream;
use Input;

class StreamController extends Controller
{
    //列表
    public function index(){
    	//获取数据
    	$data = Stream::orderBy('sort','desc') -> get();
    	//展示视图
    	return view('admin.stream.index',compact('data'));
    }

    //添加
    public function add(){
    	//判断请求类型
    	if(Input::method() == 'POST'){
    		//自动验证
    		//入表
    		$data = Input::except('_token');
    		//转化时间
    		$data['permited_at'] = strtotime($data['permited_at']);
    		//写入数据表
    		return Stream::insert($data) ? '1' : '0';
    	}else{
    		//展示视图
    		return view('admin.stream.add');
    	}
    }
}
