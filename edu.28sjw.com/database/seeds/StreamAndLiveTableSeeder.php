<?php

use Illuminate\Database\Seeder;

class StreamAndLiveTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //直播流的数据
        DB::table('stream') -> insert([
		    'stream_name'		=>		'sh09',
		    'status'			=>		'2',//永久禁播
		]);
		DB::table('stream') -> insert([
		    'stream_name'		=>		'test',
		    'status'			=>		'3',//限时禁播
		    'permited_at'		=>		strtotime('2018-08-18 10:52')
		]);
		DB::table('stream') -> insert([
		    'stream_name'		=>		'sh09/sh09',
		    'status'			=>		'1',//正常
		]);
		//live表的数据
		DB::table('live') -> insert([
		    'live_name'		=>		'北京PHP期基础班直播课程',
		    'profession_id'	=>		'1',
		    'stream_id'		=>		3,
		    'cover_img'		=>		'/statics/cover.jpg',
		    'description'	=>		'该课程是主要为了php基础班课程直播，以供远程同学听课',
		    'begin_at'		=>		strtotime(date('2017-7-19 00:00:00')),
		    'end_at'		=>		strtotime(date('2018-8-20 18:00:00')),
		]);

		DB::table('live') -> insert([
		    'live_name'		=>		'北京PHP期就业班直播课程',
		    'profession_id'	=>		'2',
		    'stream_id'		=>		3,
		    'cover_img'		=>		'/statics/cover.jpg',
		    'description'	=>		'该课程是主要为了php期就业班课程直播，以供远程同学听课',
		    'begin_at'		=>		strtotime(date('2017-8-22 00:00:00')),
		    'end_at'		=>		strtotime(date('2018-12-28 18:00:00')),
		]);
    }
}
