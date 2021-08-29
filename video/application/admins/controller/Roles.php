<?php
namespace app\admins\controller;
use think\Controller;

/**
* 角色管理
*/
class Roles extends BaseAdmin//继承baseadmin
{
	public function index(){
		$data['roles'] = $this->db->table('admin_groups')->lists();
		$this->assign('data',$data);
		return $this->fetch();
	}

	// 角色添加
	public function add(){
		$gid = (int)input('get.gid');//接受gid
		$role = $this->db->table('admin_groups')->where(array('gid'=>$gid))->item();//使用gid在数据库查询
		$role && $role['rights'] && $role['rights'] = json_decode($role['rights']);//反json解析。rights权限菜单
		$this->assign('role',$role);

		$menu_list = $this->db->table('admin_menus')->where(array('status'=>0))->cates('mid');
		$menus = $this->gettreeitems($menu_list);//将$menus_lists传入gettreeitems方法，赋给$menus
		$results = array();
		foreach ($menus as $value) {//循环显示所有权限
			$value['children'] = isset($value['children'])?$this->formatMenus($value['children']):false;//三目运算判断是否有childern，否则false，对children使用formatMenus做处理
			$results[] = $value;
		}
		$this->assign('menus',$results);
		return $this->fetch();
	}

	private function gettreeitems($items){//私有gettreeitems方法，将$menus-lists格式化返回给$menus，就是将二级三级权限在同一层级显示出来，供添加者选择
		$tree = array();
		foreach ($items as $item) {
			if(isset($items[$item['pid']])){//判断pid的值
				$items[$item['pid']]['children'][] = &$items[$item['mid']];
			}else{
				$tree[] = &$items[$item['mid']];
			}
		}
		return $tree;
	}

	private function formatMenus($items,&$res = array()){//将三级菜单提到二级目录供选择
		foreach($items as $item){
			if(!isset($item['children'])){
				$res[] = $item;
			}else{
				$tem = $item['children'];
				unset($item['children']);
				$res[] = $item;
				$this->formatMenus($tem,$res);
			}
		}
		return $res;
	}

	public function save(){
		$gid = (int)input('post.gid');//接受gid

		$data['title'] = trim(input('post.title'));
		$menus = input('post.menu/a');//“/a”提示为array[]类
		if(!$data['title']){
			exit(json_encode(array('code'=>1,'msg'=>'角色名称不能为空')));
		}
		$menus && $data['rights'] = json_encode(array_keys($menus));//将$menus的key拿出 作为权限值

		if($gid){
			$this->db->table('admin_groups')->where(array('gid'=>$gid))->update($data);
		}else{
			$this->db->table('admin_groups')->insert($data);
		}
		
		exit(json_encode(array('code'=>0,'msg'=>'save success!')));
	}

	// 删除
	public function deletes(){
		$gid = (int)input('gid');
		$this->db->table('admin_groups')->where(array('gid'=>$gid))->delete();
		exit(json_encode(array('code'=>0,'msg'=>'delete success!')));
	}
}