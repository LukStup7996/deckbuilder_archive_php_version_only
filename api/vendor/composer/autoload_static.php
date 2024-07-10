<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2c838992c3d140ddf7a92ea65fdc18da
{
    public static $prefixLengthsPsr4 = array (
        'd' => 
        array (
            'deckbuilder_archive_php_version_only\\api\\' => 41,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
        'M' => 
        array (
            'Monolog\\' => 8,
        ),
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'deckbuilder_archive_php_version_only\\api\\' => 
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
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2c838992c3d140ddf7a92ea65fdc18da::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2c838992c3d140ddf7a92ea65fdc18da::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2c838992c3d140ddf7a92ea65fdc18da::$classMap;

        }, null, ClassLoader::class);
    }
}