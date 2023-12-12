<?php

namespace William\Core\Resolver;

use Exception;
use ReflectionClass;

/**
 * Class Dependency
 *
 * @package William\Base
 */
class Dependency
{
    /** @var null | $this */
    public static $_instance = null;

    /** @var array */
    private $dependencies = [];

    /** @var array  */
    private array $references = [];

    /**
     * @return Dependency
     */
    public static function getInstance()
    {
        if (null == self::$_instance) {
            self::$_instance = new self();
            self::$_instance->setDependencyArgs([
                self::class => self::$_instance
            ]);
        }
        return self::$_instance;
    }

    /**
     * @param array $dependencies
     * @return $this
     */
    public function setDependencyArgs(array $dependencies = [])
    {
        $this->dependencies = array_merge($this->dependencies, $dependencies);
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
        return $this->_resolve($className);
    }

    /**
     * @param string $className
     * @return mixed|object|null
     * @throws \ReflectionException
     * @throws Exception
     */
    protected function _resolve(string $className)
    {
        $className   = $this->getPreference($className);
        $reflection  = new ReflectionClass($className);
        $constructor = $reflection->getConstructor();
        if (!$constructor) {
            return new $className();
        }
        $dependencies = [];
        foreach ($constructor->getParameters() as $parameter) {
            $name = $parameter->getName();
            $className = $parameter->getType() ? $parameter->getType()->getName() : '';
            $isDefaultValueAvailable = $parameter->isDefaultValueAvailable();
            $className = $this->getPreference($className);
            if (!$isDefaultValueAvailable && isset($this->dependencies[$className])) {
                $dependencies[$name] = $this->dependencies[$className];
            } elseif ($this->isSelf($parameter)) {
                $self = $this->dependencies[$className] ?: null;
                if (null == $self) {
                    $self = self::getInstance();
                    $this->dependencies[$className] = $self;
                }
                $dependencies[$name] = $self;
            } else {
                $dependencyClass = $parameter->getName();
                if (!$dependencyClass) {
                    $dependencyValue = $parameter->getDefaultValue();
                } else {
                    if ($isDefaultValueAvailable) {
                        $dependencyValue = $parameter->getDefaultValue();
                    } else {
                        $refClass = $parameter->getType() && !$parameter->getType()->isBuiltin()
                            ? new ReflectionClass($parameter->getType()->getName())
                            : null;
                        $dependencyValue = $refClass ? $this->_resolve($refClass->getName()) : null;
                    }
                }
                $dependencies[$name] = $dependencyValue;
                $this->dependencies[$className] = $dependencyValue;
            }
        }

        return $reflection->newInstanceArgs($dependencies);
    }

    /**
     * @param \ReflectionParameter $parameter
     * @return bool
     */
    protected function isSelf(\ReflectionParameter $parameter)
    {
        return $parameter->getName() === self::class;
    }

    /**
     * @param string $ref
     * @return string
     * @throws Exception
     */
    protected function getPreference(string $ref)
    {
        $references = $this->getPreferences();
        if (!empty($references[$ref])) {
            return (string)$references[$ref];
        }
        return $ref;
    }

    /**
     * @return array
     * @throws Exception
     */
    protected function getPreferences()
    {
        if (empty($this->references)) {
            $this->references = GlobalRequire::getInstance(WB_ROOT)
                ->setIdentifier('di_preference')
                ->execute();
        }
        return $this->references;
    }
}
