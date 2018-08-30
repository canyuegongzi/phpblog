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

Route::group('admin', function (){
    Route::rule('/', 'admin/index/login', 'get|post');
    Route::rule('register', 'admin/index/register', 'get|post');
    Route::rule('forget', 'admin/index/forget', 'get|post');
    Route::rule('index', 'admin/home/index', 'get');
    Route::rule('loginout', 'admin/home/loginout', 'post');
    Route::rule('catelist', 'admin/cate/list', 'get');
    Route::rule('cateadd', 'admin/cate/add', 'get|post');
    Route::rule('catesort', 'admin/cate/sort', 'post');
    Route::rule('cateedit/[:id]', 'admin/cate/edit', 'get|post');
    Route::rule('catedel', 'admin/cate/del', 'post');
    Route::rule('articlelist/[:id]', 'admin/article/list', 'get');
    Route::rule('articleadd', 'admin/article/add', 'get|post');
    Route::rule('articletop', 'admin/article/top', 'post');
    Route::rule('articleedit/[:id]', 'admin/article/edit', 'get|post');
    Route::rule('articledel', 'admin/article/del', 'post');
});
