<?php

require __DIR__ . '/vendor/autoload.php';

// $transit = '[["^ ","~:select",["~:a","~:b"]]]';
// var_dump(\slifin\Beeline::bridge($transit));
$a =
        [
            'select' => ['a', 'b', 'c'],
            // 'from' => [['test'], "test2"],
            // 'where' => ['=', 'hey', 'yo'],
        ]
    ;

var_dump(\slifin\Beeline::format($a));
