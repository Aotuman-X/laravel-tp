<?php
namespace app\admins\controller;
use think\Controller;
use Util\data\Sysdb;

/**
* 
*/
class BaseAdmin extends Controller
{
	//以session为依据判断
	public function __construct(){
		parent::__construct();
		$this->_admin = session('admin');
		//未登录不许访问
		if(!$this->_admin){
			header('location: /admins.php/admins/Account/login');//跳转
			exit;
		}
		$this->assign('admin',$this->_admin);
		//判断权限
		$this->db = new Sysdb;
	}
}