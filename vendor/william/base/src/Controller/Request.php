<?php

namespace William\Base\Controller;

use William\Base\Model\AbstractInstance;

/**
 * Class Request
 * @method array getServer()
 * @method array getCookie()
 * @method array getRequest()
 *
 * @package William\Base\Controller
 */
class Request extends AbstractInstance implements RequestInterface
{
    const CLI = 'CLI';
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const DELETE = 'DELETE';

    /** @var array */
    protected $request = [];

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
        if (!isset($_SERVER['REQUEST_METHOD'])) {
            return self::CLI;
        }
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    /**
     * @return bool
     */
    public function isCli()
    {
        return $this->getMethod() == self::CLI;
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
        return \William\Base\Route\Router::buildFullPath($this->getRequestPath());
    }

    /**
     * @return void
     */
    public function getScope()
    {
        return AbstractFrontendController::FRONT;
    }
}