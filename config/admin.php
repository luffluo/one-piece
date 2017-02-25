<?php
/**
 * This file is part of Notadd.
 * @author        TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime      2016-08-02 14:55
 */
return [
    'general' => [
        'title' => '概略导航',
        'sub'   => [
            [
                'title'  => '仪表盘',
                'active' => 'admin',
                'url'    => 'admin',
                'icon'   => 'fa-dashboard',
            ],
        ],
    ],
    'group'   => [
        'title' => '组件导航',
        'sub'   => [
            'system'  => [
                'title' => '系统管理',
                'icon'  => 'fa-cogs',
                'sub'   => [
                    [
                        'title'  => '基本配置',
                        'active' => 'admin/options*',
                        'url'    => 'admin/options',
                    ],
                ],
            ],
            'content' => [
                'title' => '内容管理',
                'icon'  => 'fa-cogs',
                'sub'   => [
                    [
                        'title'  => '分类',
                        'active' => 'admin/category*',
                        'url'    => 'admin/category',
                    ],
                    [
                        'title'  => '文章',
                        'active' => 'admin/posts*',
                        'url'    => 'admin/posts',
                    ],
                    [
                        'title'  => '页面',
                        'active' => 'admin/pages*',
                        'url'    => 'admin/pages',
                    ],
                ],
            ],
        ],
    ],
];