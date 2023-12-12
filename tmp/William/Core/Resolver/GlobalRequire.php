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
    protected array $mappingIdentifiers = [
        'route' => [
            '/vendor/william/*/web/route.php',
            '/package/*/web/route.php'
        ],
        'config' => [
            '/package/etc/config.php'
        ],
        'di_preference' => [
            '/vendor/william/*/etc/di.php',
            '/package/*/etc/di.php'
        ],
        'cli' => [
            '/vendor/william/*/etc/cli.php',
            '/package/*/etc/cli.php'
        ]
    ];

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
            self::$instance = new static($root);
        }
        return self::$instance;
    }

    /**
     * @param ...$paths
     * @return array
     * @throws \Exception
     */
    public function execute(...$paths)
    {
        $result = [];
        if ($this->getIdentifier()) {
            $paths = array_merge($paths, $this->mappingIdentifiers[$this->getIdentifier()] ?? []);
            $this->setIdentifier('');
        }
        foreach (array_filter($paths) as $path) {
            foreach (glob($this->root . $path) as $filename) {
                if (!file_exists($filename) || !is_readable($filename)) {
                    throw new \Exception(sprintf('File %s not found.', $filename));
                }
                $tmp = require $filename;
                $result = array_merge_recursive($result, $tmp ?: []);
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