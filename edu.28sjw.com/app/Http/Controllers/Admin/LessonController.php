<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//引入模型
use App\Admin\Lesson;
use Input;

class LessonController extends Controller
{
    //列表
    public function index(){
    	//获取数据
    	$data = Lesson::orderBy('sort','desc') -> get();
    	//展示视图
    	return view('admin.lesson.index',compact('data'));
    }

    //播放方法
    public function play(){
    	//获取视频的id
    	$id = Input::get('id');
    	//根据视频id，查询视频播放地址
    	$addr = Lesson::where('id',$id) -> value('video_addr');
    	return "<video src='$addr' width='95%' controls='controls'>您的浏览器不支持video标签。</video>";
    }
}
