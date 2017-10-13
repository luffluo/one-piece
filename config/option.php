<?php

/**
 * 系统的一些初始化设置
 */
return [
    'title'               => 'Luff',
    'keywords'            => 'luff,php,blog',
    'description'         => 'Just So So ...',
    'page_size'           => 20,
    'posts_list_size'     => 10,
    'post_date_format'    => 'Y-m-d',
    'comment_date_format' => 'Y-m-d H:i:s',
    'comments_list_size'  => 10,
    'sidebar_block'       => json_encode([
        'show_recent_posts', // 显示最近文章
        'show_tag', // 显示标签栏
        'show_archive', // 显示归档
        'show_other', // 显示其它杂项
    ]),
];
