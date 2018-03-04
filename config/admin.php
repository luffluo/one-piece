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
                'active'  => 'admin',
                'route'   => 'admin.home',
                'url'     => 'admin',
                'display' => true,
            ],
            [
                'title'   => '外观',
                'active'  => 'admin/themes/option',
                'route'   => 'admin.themes.option',
                'url'     => 'admin/themes/option',
                'display' => true,
            ],
        ],
    ],
    'write'     => [
        'title'   => '撰写新文章',
        'active'  => 'admin/posts/create*',
        'route'   => 'admin.posts.create',
        'url'     => 'admin/posts/create',
        'display' => true,
    ],
    'manage'    => [
        'title' => '管理',
        'sub'   => [
            [
                'title'   => '文章',
                'active'  => 'admin/posts*',
                'route'   => 'admin.posts.index',
                'url'     => 'admin/posts',
                'display' => true,
            ],
            [
                'title'   => '编辑文章',
                'active'  => 'admin/posts*',
                'route'   => 'admin.posts.edit',
                'url'     => 'admin/posts',
                'display' => false,
            ],
            [
                'title'   => '评论',
                'active'  => 'admin/comments*',
                'route'   => 'admin.comments.index',
                'url'     => 'admin/comments',
                'display' => true,
            ],
            [
                'title'   => '标签',
                'active'  => 'admin/tags*',
                'route'   => 'admin.tags.index',
                'url'     => 'admin/tags',
                'display' => true,
            ],
            [
                'title'   => '添加标签',
                'active'  => 'admin/tags*',
                'route'   => 'admin.tags.create',
                'url'     => 'admin/tags',
                'display' => false,
            ],
            [
                'title'   => '编辑标签',
                'active'  => 'admin/tags*',
                'route'   => 'admin.tags.edit',
                'url'     => 'admin/tags',
                'display' => false,
            ],
            [
                'title'   => '导航',
                'active'  => 'admin/navs*',
                'route'   => 'admin.navs.index',
                'url'     => 'admin/navs',
                'display' => true,
            ],
            [
                'title'   => '添加导航',
                'active'  => 'admin/navs*',
                'route'   => 'admin.navs.create',
                'url'     => 'admin/navs',
                'display' => false,
            ],
            [
                'title'   => '编辑导航',
                'active'  => 'admin/navs*',
                'route'   => 'admin.navs.edit',
                'url'     => 'admin/navs',
                'display' => false,
            ],
            [
                'title'   => '文件',
                'active'  => 'admin/attachments*',
                'route'   => 'admin.attachments.index',
                'url'     => 'admin/attachments',
                'display' => true,
            ],
            [
                'title'   => '编辑文件',
                'active'  => 'admin/attachments*',
                'route'   => 'admin.attachments.edit',
                'url'     => 'admin/attachments',
                'display' => false,
            ],
            [
                'title'   => '用户',
                'active'  => 'admin/users*',
                'route'   => 'admin.users.index',
                'url'     => 'admin/users',
                'display' => true,
            ],
            [
                'title'   => '编辑用户',
                'active'  => 'admin/users*',
                'route'   => 'admin.users.edit',
                'url'     => 'admin/users',
                'display' => false,
            ],
        ],
    ],
    'setting'   => [
        'title' => '设置',
        'sub'   => [
            [
                'title'   => '基本',
                'active'  => 'admin/options/general',
                'route'   => 'admin.options.general',
                'url'     => 'admin/options/general',
                'display' => true,
            ],
            [
                'title'   => '评论',
                'active'  => 'admin/options/discussion',
                'route'   => 'admin.options.discussion',
                'url'     => 'admin/options/discussion',
                'display' => true,
            ],
            [
                'title'   => '阅读',
                'active'  => 'admin/options/reading',
                'route'   => 'admin.options.reading',
                'url'     => 'admin/options/reading',
                'display' => true,
            ],
        ],
    ],
];