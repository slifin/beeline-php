<?php

require __DIR__ . '/vendor/autoload.php';

$transit = '[["^ ","~:select",["~:a","~:b"]]]';
var_dump(\slifin\Beeline::bridge($transit));
