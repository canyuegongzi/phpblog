<?php
/**
 * Created by PhpStorm.
 * User: Marvin
 * Date: 2018/8/30
 * Time: 15:24
 */
namespace app\admin\controller;

class Article extends Base
{
    //文章列表
    public function list()
    {
        $where = [];
        $catename = null;
        if (input('?id')) {
            $where = [
                'cate_id' => input('id')
            ];
            $catename = model('Cate')->where('id', input('id'))->value('catename');
        }
        $articles = model('Article')->where($where)->with('cate')->order(['is_top' => 'asc', 'create_time' => 'desc'])->paginate(10);
        $viewData = [
            'articles' => $articles,
            'catename' => $catename
        ];
        $this->assign($viewData);
        return view();
    }

    //文章添加
    public function add()
    {
        if (request()->isAjax()) {
            $data = [
                'title' => input('post.title'),
                'tags' => input('post.tags'),
                'is_top' => input('post.is_top', 0),
                'cate_id' => input('post.cateid'),
                'desc' => input('post.desc'),
                'content' => input('post.content')
            ];
            $result = model('Article')->add($data);
            if ($result == 1) {
                $this->success('文章添加成功！', 'admin/article/list');
            }else {
                $this->error($result);
            }
        }
        //次用模型的方式进行数据额查询，一般th框架有三种查询数据额方式
        $cates = model('Cate')->select();
        //一般采用模板变量的形式进行数据的初始化
        $viewData = [
            'cates' => $cates
        ];
        //赋值给模板
        $this->assign($viewData);
        return view();
    }

    //推荐
    public function top()
    {
        $data = [
            'id' => input('post.id'),
            'is_top' => input('post.is_top') ? 0 : 1
        ];
        $result = model('Article')->top($data);
        if ($result == 1) {
            $this->success('操作成功！', 'admin/article/list');
        }else {
            $this->error($result);
        }
    }

    //文章编辑
    public function edit()
    {
        if (request()->isAjax()) {
            $data = [
                'id' => input('post.id'),
                'title' => input('post.title'),
                'tags' => input('post.tags'),
                'is_top' => input('post.is_top', 0),
                'cate_id' => input('post.cateid'),
                'desc' => input('post.desc'),
                'content' => input('post.content')
            ];
            $result = model('Article')->edit($data);
            if ($result == 1) {
                $this->success('文章编辑成功！', 'admin/article/list');
            }else {
                $this->error($result);
            }
        }
        $articleInfo = model('Article')->find(input('id'));
        $cates = model('Cate')->select();
        $viewData = [
            'articleInfo' => $articleInfo,
            'cates' => $cates
        ];
        $this->assign($viewData);
        return view();
    }

    //文章删除
    public function del()
    {
        $articleInfo = model('Article')->with('comments')->find(input('post.id'));
        $result = $articleInfo->together('comments')->delete();
        if ($result) {
            $this->success('文章删除成功！', 'admin/article/list');
        }else {
            $this->error('文章删除失败！');
        }
    }

    public function up()
    {
        $data = [
            'id' => input('post.id'),
            'status' => input('post.id') ? 0 : 1
        ];
        $articleInfo = model('Article')->find($data['id']);
        $articleInfo->status = $data['status'];
        $result = $articleInfo->save();
        if ($result) {
            $this->success('操作成功！', 'admin/article/list');
        }else {
            $this->error('操作失败！');
        }
    }
}