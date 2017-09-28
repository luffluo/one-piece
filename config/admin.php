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
            [
                'title'  => '外观',
                'active' => 'admin/theme/options*',
                'url'    => 'admin/theme/options',
            ],
        ],
    ],
    'post'      => [
        'title'  => '文章',
        'icon'   => 'fa-file-text',
        'active' => 'admin/posts*',
        'url'    => 'admin/posts',
    ],
    'tag'       => [
        'title'  => '标签',
        'icon'   => 'fa-tags',
        'active' => 'admin/tags*',
        'url'    => 'admin/tags',
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
                'title'  => '阅读',
                'active' => 'admin/options/reading*',
                'url'    => 'admin/options/reading',
            ],
            [
                'title'  => '导航',
                'active' => 'admin/options/navs*',
                'url'    => 'admin/options/navs',
            ],
        ],
    ],
];