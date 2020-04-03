<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use \app\admin\model\User;
use think\Session;
use think\Cookie;

class UserController extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //管理员列表
        //判断有没有搜索条件
        if(isset($_GET['u_account']) && !empty($_GET['u_account'])){
            $where['u_account'] = $_GET['u_account'];
        }else{
            $where['u_account'] = [];
        }
        if(isset($_GET['u_post']) && !empty($_GET['u_post'])){
            $where['u_post'] = $_GET['u_post'];
        }else{
            $where['u_post'] = [];
        }
        //去除空搜索条件
        $where = array_filter($where);
        //查询数据库
        $data = User::where($where)->paginate(3);
        // 把分页数据赋值给模板变量list
        return view('admin/index',['data'=>$data]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        try {
            //接收传入的参数
            $u_account = $request->post()['u_account'];
            $u_pass = $request->post()['u_pass'];
            //判断账号和密码是否为空
            if(empty($u_account)){
                return '账号不能为空';
            }
            if(empty($u_pass)){
                return '密码不能为空';
            }
            //判断账号是否存在
            $re = User::where('u_account',$u_account)->find();
            if(!empty($re)){
                return '此账号已经存在';
            }
            $_POST['created_at'] = date("Y-m-d H:i",time());
            //密码加密
            $_POST['u_pass'] = md5($_POST['u_pass']);
            // 执行添加
            $res = User::create($_POST);
            if($res){
                return '添加成功';
            }
        } catch (\Exception $e) {
            echo $e->getMessage();die;
        }
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {

    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //用id查询单条数据
        $user = User::find($id);
        var_dump($user->toArray());
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //修改管理员
        try{
            //接收传入的参数
            $u_account = $request->post()['u_account'];
            $u_pass = $request->post()['u_pass'];
            //判断账号和密码是否为空
            if(empty($u_account)){
                return '账号不能为空';
            }
            if(empty($u_pass)){
                return '密码不能为空';
            }
            //判断账号是否存在
            $re = User::where('u_account',$u_account)->where('u_id','<>',$id)->find();
            if(!empty($re)){
                return '此账号已经存在';
            }
            $_POST['update_at'] = date("Y-m-d H:i",time());
            //判断用户是否修改密码
            //查询旧密码
            $old = User::where('u_id',$id)->find()->toArray();
            //密码加密
            if(md5($_POST['u_pass']) == $old['u_pass']){
                $_POST['u_pass'] = $old['u_pass'];
            }else {
                $_POST['u_pass'] = md5($_POST['u_pass']);
            }
            //执行修改
            $res = User::where('u_id', $id)->update($_POST);
            if($res){
                return '修改成功';
            }
        }catch (\Exception $e){
          echo $e->getMessage();die;
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //删除管理员
        try{
            //系统默认添加id为1的管理员不能删除
            if($id == 1){
                return ['status'=>'系统默认管理员不能删除','code'=>400];
            }
            //删除
            $res = User::destroy($id);
            if($res){
                return ['status'=>'删除成功','code'=>200];
            }
        }catch (\Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    /**
     * 显示登录页面
     */
    public function login(){
        return view('login/login');
    }

     /**
     * 执行登录
     *
     */
    public function do_login(Request $request)
    {
        //接收账号和密码
        $u_account = $request->post()['u_account'];
        $u_pass = $request->post()['u_pass'];
        //判断用户是否记住密码
        if(isset($request->post()['repass'])){
            //设置记住密码  默认保存30天
            $cookie = new Cookie();
            $cookie->set('u_account',$u_account,30);
            $cookie->set('u_pass',$u_pass,30);
            $cookie->set('repass','on',30);
        }
        //die;
        //判断账号和密码是否为空
        if(empty($u_account)){
            $this->error('账号不能为空');
            return '账号不能为空';
        }
        if(empty($u_pass)){
            $this->error('密码不能为空');
            return '密码不能为空';
        }
        //密码加密
        $u_pass  = md5($u_pass);
        //用账号和密码查询对应数据
        $user = User::where('u_account', $u_account)->where('u_pass',$u_pass)->find();
        if(empty($user)) {
            $this->error('账号或密码不正确');
            return '账号或密码不正确';
        }
        // 将用户账号存入session
        $session = new Session();
        $session->set('u_account',$u_account);
        //登录成功
        $this->success('登录成功','/user_index');
        return redirect('/user_index');
    }

    /**
     * 退出登录
     *
     */
    public function lgout()
    {
        // 清空session中账号u_account
        $session = new Session();
        $session->delete('u_account');
        return ['status'=>'退出成功','code'=>200];
    }
}
