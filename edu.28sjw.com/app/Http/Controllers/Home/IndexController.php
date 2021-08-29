<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //首页
    public function index(){
    	//查询直播课程列表(live表)
    	$live = \App\Admin\Live::orderBy('sort','desc') -> where('status','1') -> get();
    	//处理直播列表的数据
    	foreach ($live as $key => $value) {
    		//处理最近直播开始时间
    		$value -> start = date('Y/m/d H:i',$value -> begin_at);
    		//判断当前直播状态
    		if(time() > $value -> end_at){
    			$value -> liveStatus = '已结束';
    		}elseif(time() < $value -> begin_at){
    			$value -> liveStatus = '未开始';
    		}else{
    			$value -> liveStatus = '直播中';
    		}
    	}
    	//查询专业数据
    	$profession = \App\Admin\Profession::orderBy('sort','desc') -> get();
    	//展示视图
    	return view('home.index.index',compact('live','profession'));
    }
}
