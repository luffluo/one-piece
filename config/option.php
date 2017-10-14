<?php

/**
 * 系统的一些初始化设置
 */
return [
    'title'       => 'Luff',
    'keywords'    => 'luff,php,blog',
    'description' => 'Just So So ...',

    'page_size'        => 20, // 每页显示文章数
    'posts_list_size'  => 10, // 显示在侧边栏中的文章列表数目
    'post_date_format' => 'Y-m-d', // 文章日期格式

    'comment_date_format' => 'Y-m-d H:i:s', // 评论日期格式
    'comments_list_size'  => 10, // 显示在侧边栏中的评论列表数目
    'comments_page_size'  => 20, // 每页显示评论数

    'sidebar_block' => json_encode([
        'show_recent_posts', // 显示最近文章
        'show_tag', // 显示标签栏
        'show_archive', // 显示归档
        'show_other', // 显示其它杂项
    ]),
];
