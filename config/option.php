<?php

return [
    'title'            => 'Luff',
    'keywords'         => 'luff,php,blog',
    'description'      => 'Just So So ...',
    'page_size'        => 20,
    'posts_list_size'  => 10,
    'post_date_format' => 'Y-m-d',
    'sidebar_block'    => json_encode([
        'show_recent_rosts', // 显示最近文章
        'show_tag', // 显示标签栏
        'show_archive', // 显示归档
        'show_other', // 显示其它杂项
    ]),
];
