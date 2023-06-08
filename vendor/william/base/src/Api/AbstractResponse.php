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
    /** @var TemplateResolver|null */
    protected ?TemplateResolver $templateResolver = null;
    /** @var array */
    protected array $templates = [];

    /**
     * @return string
     */
    public function getTemplatePath(string $template)
    {
        if (!isset($this->templates[$template])) {
            $this->templates[$template] = $this->getTemplateResolver()->resolve($template);
        }
        return $this->templates[$template];
    }

    /**
     * @return TemplateResolver
     * @throws \ReflectionException
     */
    public function getTemplateResolver()
    {
        if (null == $this->templateResolver) {
            $this->templateResolver = $this->getDependencyResolver()->resolve(TemplateResolver::class);
        }
        return $this->templateResolver;
    }

    /**
     * @return DependencyResolver
     */
    protected function getDependencyResolver()
    {
        if (null === $this->dependencyResolver) {
            $this->dependencyResolver = \William\Base\Helper\DependencyResolver::getInstance();
        }
        return $this->dependencyResolver;
    }
}