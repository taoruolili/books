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
//访问/跳转到登录页
Route::get('/', function (){
    return redirect('/user_index');
});
//显示登录页面
Route::get('/login', 'admin/UserController/login');
//管理员登录
Route::post('/do_login','admin/UserController/do_login');

/**
 *管理员管理
 */
//管理员列表
Route::get('/user_index','admin/UserController/index')->middleware('Auth');
//用id查询单条数据
Route::get('/user_edit/:id','admin/UserController/edit')->middleware('Auth');
//添加管理员
Route::post('/user_save','admin/UserController/save')->middleware('Auth');
//修改管理员
Route::post('/user_update/:id','admin/UserController/update')->middleware('Auth');
//删除管理员
Route::get('/user_delete/:id','admin/UserController/delete')->middleware('Auth');
//退出登录
Route::get('/lgout','admin/UserController/lgout')->middleware('Auth');

/**
 * 读者管理
 */
//读者列表
Route::get('student_index','admin/StudentController/index')->middleware('Auth');

/**
 * 流通管理
 */
//图书借阅列表
Route::get('gobooks_index','admin/BooksController/gobooks_index')->middleware('Auth');

//图书归还列表
Route::get('backbooks_index','admin/BooksController/backbooks_index')->middleware('Auth');

/**
 * 图书管理
 */
//图书列表
Route::get('book_index','admin/BooksController/index')->middleware('Auth');

/**
 * 统计管理
 */
//统计列表
Route::get('count_index','admin/BooksController/count_index')->middleware('Auth');
