<?php
use William\Base\Controller\Request;

return [
    'base/index/index' => [
        'class' => \William\Base\Controller\Base\Index::class,
        'method' => Request::GET
    ]
];