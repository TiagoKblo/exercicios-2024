<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit238f6d89305a232d89e23ab48f1b7fd4
{
    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'Box\\Spout\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Box\\Spout\\' => 
        array (
            0 => __DIR__ . '/..' . '/box/spout/src/Spout',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit238f6d89305a232d89e23ab48f1b7fd4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit238f6d89305a232d89e23ab48f1b7fd4::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit238f6d89305a232d89e23ab48f1b7fd4::$classMap;

        }, null, ClassLoader::class);
    }
}
