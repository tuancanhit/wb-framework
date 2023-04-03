<?php

namespace William\Base\Controller;

use William\Base\Api\PageResponse\ResponseInterface as PageResponseInterface;
use William\Base\Api\RequestResponse\ResponseInterface as RequestResponseInterface;
use William\Base\Helper\DependencyResolver;
use William\Base\Helper\TemplateResolver;

/**
 * Class AbstractController
 *
 * @package William\Base\Controller
 */
abstract class AbstractController implements AbstractControllerInterface
{
    /** @var string */
    protected string $redirect = '';

    /** @var string */
    protected string $prefix = '';

    /** @var Request */
    protected Request $request;

    /** @var DependencyResolver */
    protected ?DependencyResolver $dependencyResolver = null;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return string
     */
    public function getRedirect(): string
    {
        return $this->redirect;
    }

    /**
     * @param string $redirect
     * @return $this
     */
    public function setRedirect(string $redirect)
    {
        $this->redirect = $redirect;
        return $this;
    }

    /**
     * @return PageResponseInterface|RequestResponseInterface|\William\Base\Block\BlockInterface
     */
    abstract function execute();

    /**
     * @return string
     */
    protected function getEventPrefix()
    {
        if (!$this->prefix) {
            $this->prefix = str_replace('/', '_', $this->request->getFullPath());
        }
        return $this->prefix;
    }

    /**
     * @return void
     */
    protected function beforeExecute()
    {
        $func = $this->getEventPrefix() . '_before_execute_controller';
        if (function_exists($func) && is_callable($func)) {
            $func($this);
        }
    }

    /**
     * @return void
     */
    protected function afterExecute()
    {
        $func = $this->getEventPrefix() . '_after_execute_controller';
        if (function_exists($func) && is_callable($func)) {
            $func($this);
        }
    }

    /**
     * @throws \Exception
     */
    public function launch()
    {
        $this->beforeExecute();
        $result = $this->execute();
        $this->afterExecute();

        if ($this->getRedirect()) {
            header(sprintf('Location: %s', $this->getRedirect()), true, 302);
            exit();
        }

        if ($result instanceof PageResponseInterface || $result instanceof \William\Base\Block\BlockInterface) {
            return $result->toHtml();
        }

        if ($result instanceof RequestResponseInterface) {
            return $result->makeResponse();
        }

        throw new \Exception('Register Page is incorrect');
    }

    /**
     * @return DependencyResolver
     */
    private function getDependencyResolver()
    {
        if (null === $this->dependencyResolver) {
            $this->dependencyResolver = new DependencyResolver();
        }
        return $this->dependencyResolver;
    }
}