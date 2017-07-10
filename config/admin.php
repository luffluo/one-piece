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
        'title' => '标签',
        'icon'  => 'fa-tags',
        'sub'   => [
            [
                'title'  => '标签',
                'active' => 'admin/tags*',
                'url'    => 'admin/tags',
            ],
            [
                'title'  => '添加标签',
                'active' => 'admin/tags/create*',
                'url'    => 'admin/tags/create',
            ],
        ],
    ],
    'post'      => [
        'title' => '文章',
        'icon'  => 'fa-file-text',
        'sub'   => [
            [
                'title'  => '文章',
                'active' => 'admin/posts*',
                'url'    => 'admin/posts',
            ],
            [
                'title'  => '添加文章',
                'active' => 'admin/posts/create*',
                'url'    => 'admin/posts/create',
            ],
        ],
    ],
    'user'      => [
        'title' => '用户',
        'icon'  => 'fa-user',
        'sub'   => [
            [
                'title'  => '用户',
                'active' => 'admin/users*',
                'url'    => 'admin/users',
            ],
        ],
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