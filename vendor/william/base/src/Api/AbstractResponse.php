<?php

namespace William\Base\Api;


use William\Base\Helper\DependencyResolver;
use William\Base\Helper\TemplateResolver;
use William\Base\Model\AbstractInstance;

/**
 * Class AbstractResponse
 *
 * @package William\Base\Api
 */
class AbstractResponse extends AbstractInstance
{
    /** @var DependencyResolver */
    protected ?DependencyResolver $dependencyResolver = null;

    /**
     * @return string
     */
    protected function getTemplatePath(string $template)
    {
        return $this->getDependencyResolver()
            ->resolve(TemplateResolver::class)
            ->resolve($template);
    }

    /**
     * @return DependencyResolver
     */
    protected function getDependencyResolver()
    {
        if (null === $this->dependencyResolver) {
            $this->dependencyResolver = new DependencyResolver();
        }
        return $this->dependencyResolver;
    }
}