<?php
declare(strict_types=1);

namespace William\Base\Model;

use William\Base\DependencyResolver;

/**
 * Class AbstractInstance
 *
 * @package William\Base\Model
 */
class AbstractInstance extends \William\Base\Model\DataObject
{
    /**
     * @return AbstractModel
     */
    public function create()
    {
        return (new DependencyResolver())->resolve(get_class($this));
    }

//    /**
//     * @return array
//     */
//    public function __debugInfo()
//    {
//        $vars = get_object_vars($this);
//        foreach ($vars as $prop => $value) {
//            try {
//                $rp = new \ReflectionProperty(__CLASS__, $prop);
//                if ($rp->isPrivate() || $rp->isProtected()) {
//                    unset($vars[$prop]);
//                }
//            } catch (\ReflectionException $e) {}
//        }
//        return $vars;
//    }
}