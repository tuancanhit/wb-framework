<?php

namespace William\Base\Pool;

/**
 * Class AbstractPool
 *
 * @package William\Base\Pool
 */
class AbstractPool
{
    public static $_instance = null;

    /**
     * @var array
     */
    protected array $objects = [];

    /**
     * @return $this
     */
    public function getInstance(array $args = [])
    {
        if (null == self::$_instance) {
            self::$_instance = new self(...$args);
        }
        return self::$_instance;
    }

    /**
     * @param string $class
     * @param object $objects
     * @return $this
     */
    public function addObject(string $class, $objects)
    {
        $this->objects[$class] = $objects;
        return $this;
    }

    /**
     * @param string $class
     * @return object
     * @throws \William\Base\Exception\InstanceNotFoundException
     */
    public function getObject(string $class)
    {
        if (empty($this->objects[$class])) {
            throw new \William\Base\Exception\InstanceNotFoundException(
                sprintf('Not found instance of %s in pool', $class)
            );
        }
        return $this->objects[$class];
    }
}