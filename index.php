<?php

const WB_ROOT = __DIR__;
try {
    require 'vendor/autoload.php';
    require 'vendor/wb.php';
} catch (\Exception $e) {
    echo <<<HTML
        <div style="font:12px/1.35em arial, helvetica, sans-serif;">
            <div style="margin:0 0 25px 0; border-bottom:1px solid #ccc;">
                <h3 style="margin:0;font-size:1.7em;font-weight:normal;text-transform:none;text-align:left;color:#2f2f2f;">
                Autoload error</h3>
            </div>
            <p>{$e->getMessage()}</p>
        </div>
        HTML;
    exit(1);
}

use GuzzleHttp\Client;
use GuzzleHttp\Promise;

$client = new Client(['base_uri' => 'http://127.0.0.1']);

// Initiate each request but do not block
$promises = [
    'image' => $client->getAsync('/?type=image'),
    'png'   => $client->getAsync('/?type=png'),
    'jpeg'  => $client->getAsync('/?type=jpeg'),
    'webp'  => $client->getAsync('/?type=webp')
];

$responses = Promise\Utils::unwrap($promises);

foreach ($responses as $key => $response) {
    echo $key .': '.$response->getBody()->getContents();
    echo "\n";
}