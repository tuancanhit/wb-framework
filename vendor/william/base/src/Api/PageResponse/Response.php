<?php
declare(strict_types=1);

namespace William\Base\Api\PageResponse;

use William\Base\Api\AbstractResponse;
use William\Base\Helper\TemplateResolver;
use William\Base\Model\AbstractInstance;
use William\Base\Model\DataObject;

/**
 * Interface ResponseInterface
 *
 * @api
 * @package William\Base\Api\PageResponse
 */
class Response extends AbstractResponse implements ResponseInterface
{
    /**
     * @param array $vars
     * @return $this
     */
    public function setVars(array $vars = [])
    {
        $this->setData('vars', $vars);
        return $this;
    }

    /**
     * @param string|array $template
     * @return $this
     */
    public function setTemplate($template)
    {
        $this->setData('template', $template);
        return $this;
    }

    /**
     * @return array|mixed|null
     */
    public function getVars()
    {
        return $this->getData('vars');
    }

    /**
     * @return string|array
     */
    public function getTemplate()
    {
        return $this->getData('template');
    }


    /**
     * @return false|string
     */
    public function toHtml()
    {
        $template = $this->getTemplate();
        if (!$template) {
            return '';
        }
        ob_start();
        $vars = $this->getVars();
        if (!is_array($template)) {
            include $this->getTemplatePath($template);
        } else {
            foreach ($template as $tmpl) {
                include $this->getTemplatePath($tmpl);
            }
        }
        $output = ob_get_clean();
        return $output;
    }
}