<?php

$defaultOptions = [

];

$cacheOptions = [];
if (file_exists(storage_path('app/option.php'))) {
    $cacheOptions = require storage_path('app/option.php');
}

return array_merge($defaultOptions, $cacheOptions);

