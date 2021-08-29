<?php
namespace app\index\controller;
use think\Controller;
use Util\data\Sysdb;

class Index extends controller
{

	    public function __construct(){
    	parent::__construct();
    	$this->db = new Sysdb;
    }
    public function index()
    {
    	//幻灯片
    	$slide_list = $this->db->table('slide')->where(array('type'=>0))->lists();
    	//导航标签
    	$channel_list = $this->db->table('video_label')->where(array('flag'=>'channel'))->order('ord asc')->pages(8);
    	//今日焦点
    	$today_hot_list1 = $this->db->table('video')->where(array('channel_id'=>1,'status'=>1))->pages(12);

    	$this->assign('today_hot_list1',$today_hot_list1['lists']);

        $today_hot_list2 = $this->db->table('video')->where(array('channel_id'=>2,'status'=>1))->pages(12);

        $this->assign('today_hot_list2',$today_hot_list2['lists']);

        $today_hot_list3 = $this->db->table('video')->where(array('channel_id'=>3,'status'=>1))->pages(12);

        $this->assign('today_hot_list3',$today_hot_list3['lists']);

    	$this->assign('channel_list',$channel_list['lists']);
    	$this->assign('data',$slide_list);
    	return $this->fetch();
    }

    public function cate(){
        $data['label_channel'] = (int)input('get.label_channel');
        $data['label_charge'] = (int)input('get.label_charge');
        $data['label_area'] = (int)input('get.label_area');

        $channel_list = $this->db->table('video_label')->where(array('flag'=>'channel'))->cates('id');
        $charge_list = $this->db->table('video_label')->where(array('flag'=>'charge'))->cates('id');
        $area_list = $this->db->table('video_label')->where(array('flag'=>'area'))->cates('id');

        $data['pageSize'] = 2;
        $data['page'] = max(1,(int)input('get.page'));
        $where['status'] = 1;
        if($data['label_channel']){
            $where['channel_id'] = $data['label_channel'];
        }
        if($data['label_charge']){
            $where['charge_id'] = $data['label_charge'];
        }
        if($data['label_area']){
            $where['area_id'] = $data['label_area'];
        }

        $data['data'] = $this->db->table('video')->where($where)->pages($data['pageSize']);

        $this->assign('data',$data);
        $this->assign('channel_list',$channel_list);
        $this->assign('charge_list',$charge_list);
        $this->assign('area_list',$area_list);
        return $this->fetch();
    }
    /*public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_bd568ce7058a1091"></thinkad>';
    }*/


}
