<?php
declare(strict_types=1);

namespace William\Base\Helper;

use William\Base\Exception\SystemInitFailureException;

/**
 * Class ConfigResolver
 */
class TemplateResolver
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
    public function __construct(string $scope = '')
    {
        $scope = $scope ? $scope : \William\Base\Helper\ScopeResolver::getInstance()->getScope();
        if (!$scope) {
            throw new SystemInitFailureException('Scope not found');
        }
        $this->mappings = [
            self::$_appTplPrefix => sprintf('%s/src/view/%s/', config('root_folder'), $scope),
            self::$_coreTplPrefix => sprintf('%s/vendor/william/base/src/view/%s/', config('root_folder'), $scope)
        ];

        $tmpl = config('tmpl');
        if (is_array($tmpl)) {
            $this->mappings = array_merge($this->mappings, $tmpl);
        }
        uksort($this->mappings, [$this, 'strLenghtCompare']);
        self::$_instance = $this;
    }

    /**
     * @throws SystemInitFailureException
     */
    public static function getInstance()
    {
        if (null == self::$_instance) {
            throw new SystemInitFailureException('System have not int already');
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