<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class BooksController extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //图书列表
        return view('books/book');
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
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }

    /**
     * 显示图书借阅列表
     *
     */
    public function gobooks_index()
    {
        //借阅列表
        return view('books/gobooks');
    }

    /**
     * 显示图书归还列表
     *
     */
    public function backbooks_index()
    {
        //归还列表
        return view('books/backbooks');
    }

    /**
     * 统计列表
     *
     */
    public function count_index()
    {
        //归还列表
        return view('books/count');
    }
}
