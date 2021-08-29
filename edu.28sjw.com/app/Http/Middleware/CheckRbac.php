<?php

namespace App\Http\Middleware;
use Closure;
//引入需要的门面
use Route;
use Auth;

class CheckRbac
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //对超级管理员不言中RBAC
        if(Auth::guard('admin') -> user() -> role_id != '1'){
            //RBAC鉴权
            //获取当前路由
            $route = Route::currentRouteAction();
            //获取当前用户已有的权限,auth门面中user方法，关联role表，查询auth_ac
            $ac = Auth::guard('admin') -> user() -> role -> auth_ac;
            //给每个用户赋上后台首页和后台欢迎页面的权限不进行这两个权限的判断
            $ac = strtolower($ac . ',indexcontroller@index,indexcontroller@welcome');
            //获取到的路由是完整的路径（App\Http\Controllers\Admin\IndexController@index），对其进行格式化获取到需要部分,反斜杠有转译的功能所以需要两个\\
            $routeArr = explode('\\', $route);
            //strpos判断后者是否在前者中，strtolower转换成小写，end获取最后的一部分
            if(strpos($ac,strtolower(end($routeArr))) === false){
                exit("<h1>您没有权限</h1>");
            }
        }
        return $next($request);
    }
}
