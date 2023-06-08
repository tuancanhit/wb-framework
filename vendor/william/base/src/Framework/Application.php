<?php
/**
 * Copyright © SmartOSC, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace William\Base\Framework;

use William\Base\Framework\Http\RequestHandler;

/**
 * Class Application
 *
 * @package William\Base\Framework
 */
class Application implements \William\Base\Api\Framework\AppInterface
{
    public static $_instance = null;

    protected \William\Base\Api\Framework\BootInterface $boot;
    
    /**
     * @param BootInterface $boot
     */
    public function __construct(\William\Base\Api\Framework\BootInterface $boot)
    {
        $this->boot = $boot;
        self::$_instance = $this;
    }

    /**
     * @return \William\Base\Api\Framework\BootInterface|BootInterface|\William\Base\Framework\Boot
     */
    public function getBoot()
    {
        return $this->boot;
    }

    /**
     * @return $this
     * @throws \William\Base\Exception\SystemInitFailureException
     */
    public static function getInstance()
    {
        if (null == self::$_instance) {
            throw new \William\Base\Exception\SystemInitFailureException('');
        }
        return self::$_instance;
    }


    /**
     * @param BootInterface $boot
     * @return Application
     */
    public static function create(\William\Base\Api\Framework\BootInterface $boot)
    {
        return new self(...func_get_args());
    }

    /**
     * @return void
     */
    public function run()
    {
        $request = new \William\Base\Controller\Request();
        if (!$request->isCli()) {
            (new RequestHandler(['app' => $this]))->run($request);
        }
    }
}