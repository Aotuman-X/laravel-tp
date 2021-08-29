<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//引入模型
use App\Admin\Live;

class LiveController extends Controller
{
    //列表
    public function index(){
    	//获取数据
    	$data = Live::get();
    	//展示视图
    	return view('admin.live.index',compact('data'));
    }
}
