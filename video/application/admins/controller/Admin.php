<?php
namespace app\admins\controller;
use think\Controller;
use Util\data\Sysdb;

/**
* 管理员
*/
class Admin extends BaseAdmin//继承baseadmin
{
	//管理员列表
	public function index(){
		$data['lists'] = $this->db->table('admins')->lists();
		$data['groups'] = $this->db->table('admin_groups')->cates('gid');
		$this->assign('data',$data);

		return $this->fetch();
	}

	//添加管理
	public function add(){
		$id = (int)input('get.id');
		$data['item'] = $this->db->table('admins')->where(array('id'=>$id))->item();
		$data['groups'] = $this->db->table('admin_groups')->cates('gid');
		$this->assign('data',$data);
		return $this->fetch();
	}

	//save方法
	public function save(){
		$id = (int)input('post.id');
		$data['username'] = trim(input('post.username'));
		$data['gid'] = (int)input('post.gid');
		$password = trim(input('post.pwd'));
		$data['truename'] = trim(input('post.truename'));
		$data['status'] = (int)(input('post.status'));
		

		if(!$data['username']){
			exit(json_encode(array('code'=>1,'msg'=>'用户名空')));
		}
		if(!$data['gid']){
			exit(json_encode(array('code'=>1,'msg'=>'角色空')));
		}
		if($id==0 && !$password){
			exit(json_encode(array('code'=>1,'msg'=>'密码空')));
		}
		if(!$data['truename']){
			exit(json_encode(array('code'=>1,'msg'=>'真名空')));
		}
		//md5加密密码结合用户名
		if($password){
		$data['password'] = md5($data['username'].$password);
		}

		$res = true;
		if($id==0){
			//检查
			$item = $this->db->table('admins')->where(array('username'=>$data['username']))->item();
			if($item){
				exit(json_encode(array('code'=>1,'msg'=>'已被注册')));
			}
				$data['add_time'] = time();
			//保存用户
				$res = $this->db->table('admins')->insert($data);
		}else{
			$this->db->table('admins')->where(array('id'=>$id))->update($data);
		}
		if(!$res){
			exit(json_encode(array('code'=>1,'msg'=>'save false!')));
		}
		exit(json_encode(array('code'=>0,'msg'=>'save success!')));
	}

	// 删除管理员
	public function delete(){
		$id = (int)input('post.id');
		$res = $this->db->table('admins')->where(array('id'=>$id))->delete();
		if(!$res){
			exit(json_encode(array('code'=>1,'msg'=>'delete false!')));
		}
		exit(json_encode(array('code'=>0,'msg'=>'delete success!')));
	}
}