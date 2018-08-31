<?php

namespace app\index\controller;

use think\Controller;
use think\Request;

class Base extends Controller
{
    //使用共享视图
    public function initialize()
    {
        $cates = model('Cate')->order('sort', 'asc')->select();
        $webInfo = model('System')->find();
        $topArticles = model('Article')->where(['is_top' => 1, 'status' => 1])->order('create_time', 'desc')->limit(10)->select();
        $viewData = [
            'cates' => $cates,
            'webInfo' => $webInfo,
            'topArticles' => $topArticles
        ];
        $this->view->share($viewData);
    }
}
