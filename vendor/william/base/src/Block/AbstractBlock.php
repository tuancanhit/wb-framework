<?php

namespace William\Base\Block;

use William\Base\Api\AbstractResponse;
use William\Base\Helper\DependencyResolver;
use William\Base\Helper\TemplateResolver;
use William\Base\Model\AbstractInstance;

/**
 * Class AbstractBlock
 *
 * @package William\Base\Block
 */
class AbstractBlock extends AbstractResponse implements BlockInterface
{
    /** @var string  */
    protected $template = '';

    /**
     * @param string $template
     * @return $this
     */
    public function setTemplate(string $template)
    {
        $this->setData('template', $template);
        return $this;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        if ($this->template) {
            return $this->template;
        }
        return $this->getData('template');
    }
    
    /**
     * @return string
     */
    public function toHtml()
    {
        ob_start();
        $block = $this;
        include ($this->getDependencyResolver()
            ->resolve(TemplateResolver::class)
            ->resolve($this->getTemplate()));
        $output = ob_get_clean();
        return $output;
    }

}