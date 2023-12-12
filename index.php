<?php

use William\Core\Framework\Http\App;

const WB_ROOT = __DIR__;
try {
    require 'vendor/autoload.php';
    require 'package/etc/wb.php';
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
$application = new App(['wb_root' => WB_ROOT]);
$application->run();