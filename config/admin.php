<?php
/**
 * This file is part of Luff.
 * @author        Luff
 */
return [
    'bootstrap' => [
        'title' => '控制台',
        'sub'   => [
            [
                'title'   => '概要',
                'active'  => '',
                'route'   => 'admin.home',
                'display' => true,
            ],
            [
                'title'   => '外观',
                'active'  => '',
                'route'   => 'admin.themes.option',
                'display' => true,
            ],
        ],
    ],
    'write'     => [
        'title'   => '撰写新文章',
        'active'  => '',
        'route'   => 'admin.posts.create',
        'display' => true,
    ],
    'manage'    => [
        'title' => '管理',
        'sub'   => [
            [
                'title'   => '文章',
                'active'  => '',
                'route'   => 'admin.posts.index',
                'display' => true,
            ],
            [
                'title'   => '编辑文章',
                'active'  => '',
                'route'   => 'admin.posts.edit',
                'display' => false,
            ],
            [
                'title'   => '评论',
                'active'  => '',
                'route'   => 'admin.comments.index',
                'display' => true,
            ],
            [
                'title'   => '标签',
                'active'  => '',
                'route'   => 'admin.tags.index',
                'display' => true,
            ],
            [
                'title'   => '添加标签',
                'active'  => '',
                'route'   => 'admin.tags.create',
                'display' => false,
            ],
            [
                'title'   => '编辑标签',
                'active'  => '',
                'route'   => 'admin.tags.edit',
                'display' => false,
            ],
            [
                'title'   => '导航',
                'active'  => '',
                'route'   => 'admin.navs.index',
                'display' => true,
            ],
            [
                'title'   => '添加导航',
                'active'  => '',
                'route'   => 'admin.navs.create',
                'display' => false,
            ],
            [
                'title'   => '编辑导航',
                'active'  => '',
                'route'   => 'admin.navs.edit',
                'display' => false,
            ],
            [
                'title'   => '文件',
                'active'  => '',
                'route'   => 'admin.attachments.index',
                'display' => true,
            ],
            [
                'title'   => '编辑文件',
                'active'  => '',
                'route'   => 'admin.attachments.edit',
                'display' => false,
            ],
            [
                'title'   => '用户',
                'active'  => '',
                'route'   => 'admin.users.index',
                'display' => true,
            ],
            [
                'title'   => '编辑用户',
                'active'  => '',
                'route'   => 'admin.users.edit',
                'display' => false,
            ],
        ],
    ],
    'setting'   => [
        'title' => '设置',
        'sub'   => [
            [
                'title'   => '基本',
                'active'  => '',
                'route'   => 'admin.options.general',
                'display' => true,
            ],
            [
                'title'   => '评论',
                'active'  => '',
                'route'   => 'admin.options.discussion',
                'display' => true,
            ],
            [
                'title'   => '阅读',
                'active'  => '',
                'route'   => 'admin.options.reading',
                'display' => true,
            ],
        ],
    ],
];