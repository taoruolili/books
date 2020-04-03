<?php

namespace app\http\middleware;
use think\Session;

class Auth
{
    public function handle($request, \Closure $next)
    {
        //检测session中是否有用户账号
        $session = new Session();
        if(!$session->get('u_account')){
            //未登录跳转到登录页
            return redirect('/login');
        }

        return $next($request);
    }
}
