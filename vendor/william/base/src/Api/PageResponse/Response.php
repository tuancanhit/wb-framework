<?php
declare(strict_types=1);

namespace William\Base\Api\PageResponse;

use William\Base\Model\AbstractInstance;
use William\Base\Model\DataObject;

/**
 * Interface ResponseInterface
 *
 * @api
 * @package William\Base\Api\PageResponse
 */
class Response extends AbstractInstance implements ResponseInterface
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
     * @param string $template
     * @return $this
     */
    public function setTemplate(string $template)
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
     * @return $this
     */
    public function getTemplate()
    {
        return $this->getData('template');
    }
}