<?php

namespace William\Base\Controller;

use William\Base\Api\PageResponse\ResponseInterface as PageResponseInterface;
use William\Base\Api\RequestResponse\ResponseInterface as RequestResponseInterface;

/**
 * Class AbstractController
 *
 * @package William\Base\Controller
 */
abstract class AbstractController implements AbstractControllerInterface
{
    /** @var string */
    protected string $scope = '';

    /** @var Request */
    protected Request $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
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
        return __DIR__ . "../../View/{$this->scope}/{$template}";
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
            $vars = $result->getVars();
            include $this->getTemplatePath($result->getTemplate());
            return;
        }
        if ($result instanceof RequestResponseInterface) {
            echo $result->toJson();
            return;
        }
        throw new \Exception('Register Page Is Incorrect');
    }
}