<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use \app\admin\model\User;
use think\Session;

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
        $data = User::paginate(1);
        var_dump($data->toArray());
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
            $user = new User;
            // 过滤post数组中的非数据表字段数据
            $res = $user->save($_POST);
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
            }else{
                $_POST['u_pass'] = md5($_POST['u_pass']);
            }
            $_POST['u_pass'] = md5($_POST['u_pass']);
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
                return '系统默认添加管理员不能删除';
            }
            //删除
            $res = User::delete($id);
            if($res){
                return '删除成功';
            }
        }catch (\Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    /**
 * 登录
 *
 */
    public function login(Request $request)
    {
        //接收账号和密码
        $u_account = $request->post()['u_account'];
        $u_pass = $request->post()['u_pass'];
        //判断账号和密码是否为空
        if(empty($u_account)){
            return '账号不能为空';
        }
        if(empty($u_pass)){
            return '密码不能为空';
        }
        //密码加密
        $u_pass  = md5($u_pass);
        //用账号和密码查询对应数据
        $user = User::where('u_account', $u_account)->where('u_pass',$u_pass)->find();
        if(empty($user)) {
            return '账号或密码不正确';
        }
        // 将用户账号存入session
        $session = new Session();
        $session->set('u_account',$u_account);
        //登录成功
        return '成功';
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
        return '退出';
    }
}
