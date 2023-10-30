<?php
/**
 * Copyright © Will, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace William\Core\Resolver;

/**
 * Class GlobalRequireResolver
 *
 * @package William\Base\Helper
 */
class GlobalRequire
{
    protected static ?GlobalRequire $instance = null;
    protected string $identifier = '';

    /**
     * @param string $root
     */
    public function __construct(protected string $root = WB_ROOT){}

    /**
     * @param string $root
     * @return GlobalRequire
     */
    public static function getInstance(string $root = WB_ROOT)
    {
        if (null == self::$instance) {
            self::$instance = new self($root);
        }
        return self::$instance;
    }

    /**
     * @return array
     */
    protected function getFromCache()
    {
        return [];
    }

    /**
     * @param ...$paths
     * @return array
     */
    public function execute(...$paths)
    {
        $result = [];
        foreach ($paths as $path) {
            foreach (glob($this->root . $path) as $filename) {
                if (!is_readable($filename)) {
                    continue;
                }
                $tmp = require $filename;
                $result = array_merge_recursive($result, $tmp);
            }
        }
        return $result;
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     * @return $this
     */
    public function setIdentifier(string $identifier)
    {
        $this->identifier = $identifier;
        return $this;
    }
}