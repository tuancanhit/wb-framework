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
    protected string $scope = '';

    /** @var string  */
    protected string $redirect = '';

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
     * @return PageResponseInterface|RequestResponseInterface
     */
    abstract function execute();

    /**
     * @return void
     */
    protected function beforeExecute(){}

    /**
     * @return void
     */
    protected function afterExecute(){}

    /**
     * @return string
     */
    protected function getTemplatePath(string $template)
    {
        return $this->getDependencyResolver()
            ->clearDependencyArgs()
            ->setDependencyArgs(['scope' => $this->scope])
            ->resolve(TemplateResolver::class)
            ->resolve($template);
    }

    /**
     * @throws \Exception
     */
    public function launch()
    {
        $this->beforeExecute();
        $result = $this->execute();
        $this->afterExecute();
        if ($result instanceof PageResponseInterface) {
            if ($this->getRedirect()) {
                $this->getDependencyResolver()->resolve($this->getRedirect())->launch();
            } else {
                if (!$result->getTemplate()) {
                    return;
                }
                $vars = $result->getVars();
                include $this->getTemplatePath($result->getTemplate());
            }
            return;
        }
        if ($result instanceof RequestResponseInterface) {
            echo $result->makeResponse();
            return;
        }
        throw new \Exception('Register Page Is Incorrect');
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