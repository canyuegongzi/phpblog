<?php
/**
 * Created by PhpStorm.
 * User: Marvin
 * Date: 2018/8/30
 * Time: 15:26
 */
namespace app\common\validate;

use think\Validate;

class Article extends Validate
{
    protected $rule = [
        'title|文章标题' => 'require|unique:article',
        'tags|标签' => 'require',
        'cate_id|所属栏目' => 'require',
        'desc|文章概要' => 'require',
        'content|内容' => 'require',
        'is_top|推荐' => 'require'
    ];

    //添加场景
    public function sceneAdd()
    {
        return $this->only(['title', 'tags', 'cateid', 'desc', 'content']);
    }

    //推荐场景
    public function sceneTop()
    {
        return $this->only(['is_top']);
    }

    //编辑场景
    public function sceneEdit()
    {
        return $this->only(['title', 'tags', 'is_top', 'cate_id', 'desc', 'content']);
    }

    //投稿场景
    public function scenePost()
    {
        return $this->only(['title', 'tags', 'cate_id', 'desc', 'content']);
    }
}