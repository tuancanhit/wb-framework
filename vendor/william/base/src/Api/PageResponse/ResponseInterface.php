<?php
declare(strict_types=1);

namespace William\Base\Api\PageResponse;

/**
 * Interface ResponseInterface
 *
 * @api
 * @package William\Base\Api\PageResponse
 */
interface ResponseInterface
{
    public function setVars(array $vars = []);
    public function setTemplate($template);
    public function getVars();
    public function getTemplate();
    public function toHtml();
}