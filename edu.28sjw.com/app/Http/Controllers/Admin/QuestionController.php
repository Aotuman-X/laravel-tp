<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//引入模型
use App\Admin\Question;
//引入excel
use Excel;
use Input;

class QuestionController extends Controller
{
    //列表
    public function index(){
    	//获取数据
    	$data = Question::get();
    	//展示视图
    	return view('admin.question.index',compact('data'));
    }

    //导出方法
    public function export(){
    	//代码
    	//excel表格数据的数据内容（第一行是表头）
    	$cellData = [
            ['序号','题干','所属试卷','分值','选项','正确答案','添加时间']
        ];
        //查询数据
        $data = Question::all();
        //循环写入行，直接查询数据写入，因为$cellData[]二维数组中写入的是值而不是键值对
        foreach ($data as $key => $value) {
        	$cellData[] = [
        			$value -> id,//序号
        			$value -> question,//题干
        			$value -> paper -> paper_name,//所属试卷
        			$value -> score,//分值
        			$value -> options,//选项
        			$value -> answer,//答案
        			$value -> created_at,//时间
        	];
        }
        // dd($cellData);
        //使用excel类（参数1是文件名，sha1方法生成字符串40位（md5生成32位随机字符串），通过时间加随机数重命名防止下载同一文件出现重名无法下载的情况，在门面中使用外部数据需要引用use ($cellData)）
        Excel::create(sha1(time().rand(1000,9999)),function($excel) use ($cellData){
        	//在此处可以使用celldata
            $excel->sheet('题库', function($sheet) use ($cellData){
            	//写入行数据
                $sheet->rows($cellData);
            });
        })->export('xls');//导出
    }

    //导入操作
    public function import(){
    	//判断请求类型
    	if(Input::method() == 'POST'){
    		//数据导入操作
    		$filePath = '.' . Input::get('excelpath');//文件的路径
		    Excel::load($filePath, function($reader) {
		        $data = $reader -> getSheet(0) -> toArray();
		        //读取全部的数据
		        $temp = [];
		        foreach ($data as $key => $value) {
		        	//排除表头
		        	if($key == '0'){
		        		continue;
		        	}
		        	//此时value是数组
		        	$temp[] = [
		        		'question'		=>		$value[0],//题干
		        		'paper_id'		=>		Input::get('paper_id'),//试卷id
		        		'score'			=>		$value[3],//分值
		        		'options'		=>		$value[1],//选项
		        		'answer'		=>		$value[2],//答案
		        		'created_at'	=>		date('Y-m-d H:i:s'),//创建时间
		        	];
		        	
		        }
		        //写入数据
		        $result = Question::insert($temp);
    			echo $result ? '1' : '0';
		    });
    	}else{
    		//查询试卷的列表
	    	$list = \App\Admin\Paper::get();
	    	//展示视图
	    	return view('admin.question.import',compact('list'));
    	}
    }
}
