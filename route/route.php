<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

//管理员登录
Route::post('/login','admin/UserController/login');
//退出登录
Route::get('/lgout','admin/UserController/lgout');

/**
 *管理员管理
 */
//管理员管理
Route::get('/user_index','admin/UserController/index');
//用id查询单条数据
Route::get('/user_edit/:id','admin/UserController/edit');
//添加管理员
Route::post('/user_save','admin/UserController/save');
//修改管理员
Route::post('/user_update/:id','admin/UserController/update');
//删除管理员
Route::get('/user_delete/:id','admin/UserController/delete');


/**
 * 学生管理
 */
