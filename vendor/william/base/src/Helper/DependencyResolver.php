<?php

namespace William\Base\Helper;

use Exception;
use ReflectionClass;
use William\Base\Exception\InstanceNotFoundException;

/**
 * Class DependencyResolver
 *
 * @package William\Base
 */
class DependencyResolver
{
    /** @var null | $this */
    public static $_instance = null;

    /** @var array */
    private $dependencies = [];

    /** @var \William\Base\Pool\DependencyInjectionPool */
    private $dependencyPool;

    /** DependencyResolver */
    public function __construct()
    {
        $this->dependencyPool = new \William\Base\Pool\DependencyInjectionPool();
    }

    /**
     * @return DependencyResolver|null
     */
    public static function getInstance()
    {
        if (null == self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @param string $key
     * @param object $value
     * @return $this
     */
    public function setDependencyArgs(array $dependencies = [])
    {
        $this->dependencies = array_merge($this->dependencies, $dependencies);
        return $this;
    }

    /**
     * @return $this
     */
    public function clearDependencyArgs()
    {
        $this->dependencies = [];
        return $this;
    }

    /**
     * @return $this
     */
    public function replaceDependencyArgs(string $name, $value)
    {
        $this->dependencies[$name] = $value;
        return $this;
    }

    /**
     * @param string $className
     * @return mixed|object|null
     * @throws \ReflectionException
     * @throws Exception
     */
    public function resolve(string $className)
    {
        $cachedInstance = $this->getFromPool($className);
        if (null !== $cachedInstance) {
            return $cachedInstance;
        }
        $instance = $this->_resolve(...func_get_args());
        $this->dependencyPool->addObject($className, $instance);
        return $instance;
    }

    /**
     * @param string $className
     * @return mixed|object|null
     * @throws \ReflectionException
     * @throws Exception
     */
    protected function _resolve(string $className)
    {
        $reflection = new ReflectionClass($className);
        $constructor = $reflection->getConstructor();
        if (!$constructor) {
            return new $className();
        }
        $dependencies = [];
        foreach ($constructor->getParameters() as $parameter) {
            $name = $parameter->getName();

            if (isset($this->dependencies[$name])) {
                $dependencies[] = $this->dependencies[$name];
            } else {
                $dependencyClass = $parameter->getClass();
                if (!$dependencyClass) {
                    $dependencyValue = $parameter->getDefaultValue();
                } else {
                    $dependencyValue = $this->_resolve($dependencyClass->getName());
                }
                $dependencies[] = $dependencyValue;
                $this->dependencies[$name] = $dependencyValue;
            }
        }

        return $reflection->newInstanceArgs($dependencies);
    }

    /**
     * @param string $class
     * @return object|null
     */
    protected function getFromPool(string $class)
    {
        try {
            return $this->dependencyPool->getObject($class);
        } catch (InstanceNotFoundException $e) {
            return null;
        }
    }
}
