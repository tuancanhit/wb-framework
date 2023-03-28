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
    public function __construct(string $scope)
    {
        $this->mappings = [
            self::$_appTplPrefix  => sprintf('%s/src/view/%s/', config('root_folder'), $scope),
            self::$_coreTplPrefix => sprintf('%s/vendor/william/base/src/view/%s/', config('root_folder'), $scope)
        ];
        if (config('tmpl')) {
            $this->mappings = array_merge($this->mappings, config('tmpl'));
        }
        self::$_instance = $this;
    }

    /**
     * @throws SystemInitFailureException
     */
    public static function getInstance()
    {
        if (null == self::$_instance) {
            throw new SystemInitFailureException('Must init system first');
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
}