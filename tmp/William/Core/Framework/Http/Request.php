<?php
/**
 * Copyright © Will, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace William\Core\Framework\Http;

use William\Core\Api\Framework\Http\RequestInterface;
use William\Core\Model\DataObject;

/**
 * Class Request
 *
 * @package William\Core\Http
 */
class Request extends DataObject implements RequestInterface
{
    /** @var array */
    protected array $request = [];

    /**  */
    public function __construct()
    {
        $this->request = $_REQUEST;
        $data = [
            'server' => $_SERVER,
            'cookie' => $_COOKIE,
            'request' => $_REQUEST,
            'method' => $this->getMethod(),
        ];
        return parent::__construct($data);
    }

    /**
     * @param string $key
     * @param        $default
     * @return mixed|null
     */
    public function getParam(string $key, $default = null)
    {
        if (!isset($this->request[$key])) {
            return $default;
        }
        return $this->request[$key];
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->request;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        if ($this->isCli()) {
            return self::CLI;
        }
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    /**
     * @return bool
     */
    public function isCli()
    {
        return strtoupper(PHP_SAPI) == self::CLI;
    }

    /**
     * @return string|null
     */
    public function getRequestPath()
    {
        $requestUri = $this->getServer()['REQUEST_URI'];
        $pattern = '/^[^?]+/';
        if (preg_match($pattern, $requestUri, $matches)) {
            if (empty($matches[0])) {
                return null;
            }
            return $matches[0];
        }
        return null;
    }

    /**
     * @return string
     */
    public function getFullPath()
    {
        return self::buildFullPath($this->getRequestPath());
    }

    /**
     * @param string $path
     * @return string
     */
    public static function buildFullPath(string $path)
    {
        $path = array_values(
            array_filter(
                explode('/', $path)
            )
        );
        if (empty($path)) {
            return '/';
        }

        return implode('/', $path);
    }

    /**
     * @return string
     */
    public function getScope()
    {
        if ($this->isCli()) {
            return self::CLI;
        }
        return '';
    }

    /**
     * @return string
     */
    public function getUserIpAddress()
    {
        $ip = 'NOT_FOUND';
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}