<?php
declare(strict_types=1);

namespace William\Base\Helper;

use William\Base\Exception\SystemInitFailureException;
use William\Base\Model\AbstractInstance;

/**
 * Class ConfigResolver
 */
class TemplateResolver extends AbstractInstance
{
    /** @var TemplateResolver|null */
    private static ?TemplateResolver $_instance = null;

    /** @var array */
    private array $mappings = [];

    /** @var string */
    public static $_appTplPrefix = '@app::';

    /** @var string */
    public static $_coreTplPrefix = '@core::';

    /**
     * @param array $configs
     */
    public function __construct(array $data = [], string $scope = '')
    {
        $scope   = $scope ? $scope : \William\Base\Helper\ScopeResolver::getInstance()->getScope();
        $rootDir = \William\Base\Framework\HttpApplication::getInstance()->getBoot()->getRootDir();

        if (!$scope || !$rootDir) {
            throw new SystemInitFailureException('Scope or root dir not found');
        }
        $this->mappings = [
            self::$_appTplPrefix  => sprintf('%s/src/view/%s/', $rootDir, $scope),
            self::$_coreTplPrefix => sprintf('%s/vendor/william/base/src/view/%s/', $rootDir, $scope)
        ];

        $tmpl = config('tmpl');
        if (is_array($tmpl)) {
            $this->mappings = array_merge($this->mappings, $tmpl);
        }
        uksort($this->mappings, [$this, 'strLenghtCompare']);
        self::$_instance = $this;
        parent::__construct($data);
    }

    /**
     * @throws SystemInitFailureException
     */
    public static function getInstance()
    {
        if (null == self::$_instance) {
            throw new SystemInitFailureException('System have not init already');
        }
        return self::$_instance;
    }

    /**
     * @param string $template
     * @return string
     */
    public function resolve(string $template)
    {
        $area = $this->getArea($template);
        return str_replace(
            $area, $this->mappings[$area], $template
        );
    }

    /**
     * @param string $template
     * @return mixed
     * @throws \Exception
     */
    protected function getArea(string $template)
    {
        $template = strtolower($template);
        foreach (array_keys($this->mappings) as $scope) {
            $lenght = strlen($scope);
            if (substr($template, 0, $lenght) == $scope) {
                return $scope;
            }
        }
        throw new \Exception('Template area not found');
    }

    /**
     * @param string $a
     * @param string $b
     * @return bool
     */
    public function strLenghtCompare($a, $b)
    {
        return strlen($a) < strlen($b);
    }
}