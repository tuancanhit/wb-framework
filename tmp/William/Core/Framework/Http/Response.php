<?php
/**
 * Copyright © Will, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace William\Core\Framework\Http;

use William\Core\Api\Framework\Http\ResponseInterface;
use William\Core\Model\DataObject;

/**
 * Class Response
 *
 * @package William\Core\Framework\Http
 */
class Response extends DataObject implements ResponseInterface
{
    const RESPONSE_TYPE_HTML = 'html';
    const RESPONSE_TYPE_JSON = 'json';

    protected string $responseType    = self::RESPONSE_TYPE_HTML;
    protected string $responseCharset = 'charset=utf-8';

    protected string|int|bool|array $content;

    /**
     * @param ...$args
     * @return void
     */
    protected function afterConstruct(...$args)
    {
        $this->content = '<h1>Default empty request response</h1>';
    }

    /**
     * @return bool|int|string
     */
    public function getContent(): bool|int|string
    {
        return $this->content;
    }

    /**
     * @param bool|int|string|array $content
     * @return $this
     */
    public function setContent(bool|int|string|array $content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getResponseType(): string
    {
        return $this->responseType;
    }

    /**
     * @param string $responseType
     * @return $this
     */
    public function setResponseType(string $responseType)
    {
        $this->responseType = $responseType;
        return $this;
    }

    /**
     * @return string
     */
    public function getResponseCharset(): string
    {
        return $this->responseCharset;
    }

    /**
     * @param string $responseCharset
     * @return $this
     */
    public function setResponseCharset(string $responseCharset)
    {
        $this->responseCharset = $responseCharset;
        return $this;
    }

    /**
     * @return void
     */
    public function sendResponse()
    {
        if ($this->getResponseType() == self::RESPONSE_TYPE_JSON) {
            header(sprintf('Content-Type: application/json; %s', $this->getResponseCharset()));
            if (is_array($this->content)) {
                $this->content = json_encode($this->content);
            }
        }
        echo $this->content;
    }
}