<?php

namespace William\Base\Helper;

use William\Base\Exception\SystemInitFailureException;

/**
 * Class ScopeResolver
 *
 * @package William\Base\Helper
 */
class ScopeResolver
{
    /** @var string  */
    protected string $scope = '';

    /** @var ScopeResolver|null  */
    protected static $_instance = null;

    /**
     * @param string $scope
     */
    public function __construct(string $scope)
    {
        $this->scope = $scope;
        self::$_instance = $this;
    }

    /**
     * @return ScopeResolver|null
     */
    public static function getInstance(): ?ScopeResolver
    {
        if (null == self::$_instance) {
            throw new SystemInitFailureException('Scope does not init');
        }
        return self::$_instance;
    }

    /**
     * @return string
     */
    public function getScope(): string
    {
        return $this->scope;
    }
}