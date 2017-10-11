<?php
/**
 * This file is part of Luff.
 * @author        Luff
 */
return [
    'bootstrap' => [
        'title' => '控制台',
        'icon'  => 'fa-dashboard',
        'sub'   => [
            [
                'title'  => '概要',
                'active' => 'admin',
                'url'    => 'admin',
            ],
            [
                'title'  => '外观',
                'active' => 'admin/theme/options*',
                'url'    => 'admin/theme/options',
            ],
        ],
    ],
    'manage'    => [
        'title' => '管理',
        'icon'  => 'fa-tasks',
        'sub'   => [
            [
                'title'  => '文章',
                // 'icon'   => 'fa-file-text',
                'active' => 'admin/posts*',
                'url'    => 'admin/posts',
            ],
            [
                'title'  => '评论',
                // 'icon'   => 'fa-file-text',
                'active' => 'admin/comments*',
                'url'    => 'admin/comments',
            ],
            [
                'title'  => '标签',
                // 'icon'   => 'fa-tags',
                'active' => 'admin/tags*',
                'url'    => 'admin/tags',
            ],
            [
                'title'  => '导航',
                // 'icon'   => 'fa-navicon',
                'active' => 'admin/navs*',
                'url'    => 'admin/navs',
            ],
            [
                'title'  => '用户',
                // 'icon'   => 'fa-users',
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
                'active' => 'admin/options/general*',
                'url'    => 'admin/options/general',
            ],
            [
                'title'  => '评论',
                'active' => 'admin/options/discussion*',
                'url'    => 'admin/options/discussion',
            ],
            [
                'title'  => '阅读',
                'active' => 'admin/options/reading*',
                'url'    => 'admin/options/reading',
            ],
        ],
    ],
];