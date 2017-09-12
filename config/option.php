<?php

return [
    'title'          => 'Luff',
    'keywords'       => 'luff,php,blog',
    'description'    => 'Just So So ...',
    'pageSize'       => 20,
    'postsListSize'  => 10,
    'postDateFormat' => 'Y-m-d',
    'sidebarBlock'   => json_encode([
        'ShowRecentPosts',
        'ShowTag',
        'ShowArchive',
        'ShowOther',
    ]),
];
