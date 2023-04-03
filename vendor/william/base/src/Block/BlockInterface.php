<?php

namespace William\Base\Block;

/**
 * Interface BlockInterface
 *
 * @api
 * @package William\Base\Block
 */
interface BlockInterface
{
    public function setTemplate(string $template);
    public function getTemplate();
    public function setData($key, $value = null);
    public function toHtml();
}