<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Comment extends Controller
{
    //评论列表
    public function all()
    {
        $articleTitle = null;
        $where = [];
        if (input('?id')) {
            $articleTitle = model('Article')->where('id', input('id'))->value('title');
            $where = [
                'article_id' => input('id')
            ];
        }
        $comments = model('Comment')->where($where)->with('article,member')->order('create_time', 'desc')->paginate(10);
        $viewData = [
            'articleTitle' => $articleTitle,
            'comments' => $comments
        ];
        $this->assign($viewData);
        return view();
    }

    //评论删除
    public function del()
    {
        $commentInfo = model('Comment')->find(input('post.id'));
        $result = $commentInfo->delete();
        if ($result) {
            $this->success('删除成功！', 'admin/comment/all');
        }else {
            $this->error('删除是吧！');
        }
    }
}
