<?php

namespace William\Base\Helper;

use Exception;
use ReflectionClass;

/**
 * Class DependencyResolver
 *
 * @package William\Base
 */
class DependencyResolver
{
    /** @var array */
    private $dependencies = [];

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
                    $dependencyValue = $this->resolve($dependencyClass->getName());
                }
                $dependencies[] = $dependencyValue;
                $this->dependencies[$name] = $dependencyValue;
            }
        }

        return $reflection->newInstanceArgs($dependencies);
    }
}
