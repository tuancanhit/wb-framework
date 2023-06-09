<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1c44cd6f0722845a9ea2f12a7733b720
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'William\\Base\\' => 13,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
        'M' => 
        array (
            'Monolog\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'William\\Base\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/src',
        ),
        'Monolog\\' => 
        array (
            0 => __DIR__ . '/..' . '/monolog/monolog/src/Monolog',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1c44cd6f0722845a9ea2f12a7733b720::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1c44cd6f0722845a9ea2f12a7733b720::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit1c44cd6f0722845a9ea2f12a7733b720::$classMap;

        }, null, ClassLoader::class);
    }
}
