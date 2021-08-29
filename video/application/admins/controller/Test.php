<?php
namespace app\admins\controller;
use think\Controller;
use Util\data\Sysdb;

/**
* 
*/
class Test extends Controller
{
	
	public function index(){
		$this->db = new Sysdb;
		$res = $this->db->table('admins')->field('id,username')->lists();//lists按默认索引
		dump($res);

		echo '<hr>';
		$res2 = $this->db->table('admins')->field('id,username')->cates('id');//cates可规定按id索引
		dump($res2);
	}
}