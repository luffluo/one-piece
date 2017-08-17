<?php
/**
 * This file is part of Luff.
 * @author        Luff
 */
return [
    'bootstrap' => [
        'title' => '控制台',
        'icon'  => 'fa-tasks',
        'sub'   => [
            [
                'title'  => '概要',
                'active' => 'admin',
                'url'    => 'admin',
            ],
        ],
    ],
    'tag'       => [
        'title'  => '标签',
        'icon'   => 'fa-tags',
        'active' => 'admin/tags*',
        'url'    => 'admin/tags',
    ],
    'post'      => [
        'title'  => '文章',
        'icon'   => 'fa-file-text',
        'active' => 'admin/posts*',
        'url'    => 'admin/posts',
    ],
    'user'      => [
        'title'  => '用户',
        'icon'   => 'fa-user',
        'active' => 'admin/users*',
        'url'    => 'admin/users',
    ],
    'setting'   => [
        'title' => '设置',
        'icon'  => 'fa-cogs',
        'sub'   => [
            [
                'title'  => '基本',
                'active' => 'admin/options*',
                'url'    => 'admin/options',
            ],
        ],
    ],
];