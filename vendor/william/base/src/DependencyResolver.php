<?php

namespace William\Base;

use Exception;
use ReflectionClass;

/**
 * Class DependencyResolver
 *
 * @package William\Base
 */
class DependencyResolver
{
    /** @var array  */
    private $dependencies = [];

    /**
     * @param string $key
     * @param object $value
     * @return void
     */
    public function addDependency($key, $value)
    {
        $this->dependencies[$key] = $value;
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
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    $dependencies[] = $this->resolve($dependencyClass->getName());
                }
            }
        }

        return $reflection->newInstanceArgs($dependencies);
    }
}
