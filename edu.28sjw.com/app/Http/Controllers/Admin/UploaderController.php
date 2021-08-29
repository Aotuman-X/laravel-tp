<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//引入storage
use Storage;

class UploaderController extends Controller
{
    //上传文件的处理
    public function webuploader(Request $request){
    	//判断是否有文件上传成功
    	if($request -> hasFile('file') && $request -> file('file') -> isValid()){
    		//有文件上传（重点）,put方法中两个参数，文件名和文件内容，file_get_contents方法获取文件内容，文件内容就是存储路径通过$request -> file('file') -> path()方法获取
    		$filename = sha1(time() . $request -> file('file') -> getClientOriginalName()) . '.' .  $request -> file('file') -> getClientOriginalExtension();
    		//文件保存/移动
    		Storage::disk('public') -> put($filename, file_get_contents($request -> file('file') -> path()));
    		//返回数据
    		$result = [
    			'errCode'		=>		'0',
    			'errMsg'		=>		'',
    			'succMsg'		=>		'文件上传成功！',
    			'path'			=>		'/storage/' . $filename,
    		];
    	}else{
    		//没有文件被上传或者出错
    		$result = [
    			'errCode'		=>		'000001',
    			'errMsg'		=>		$request -> file('file') -> getErrorMessage()
    		];
    	}
    	//返回信息
    	return response() -> json($result);
    }
}
