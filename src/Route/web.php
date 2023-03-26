<?php
use William\Base\Controller\Request;

return [
    'index/index/index' => [
        'class' => \William\Wb\Controller\Home\Index::class,
        'method' => Request::GET
    ]
];