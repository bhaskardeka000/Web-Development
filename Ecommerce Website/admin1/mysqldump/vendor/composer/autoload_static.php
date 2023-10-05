<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit90aca0b7a54f3a17976e1226fab7c664
{
    public static $prefixLengthsPsr4 = array (
        'I' => 
        array (
            'Ifsnop\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Ifsnop\\' => 
        array (
            0 => __DIR__ . '/..' . '/ifsnop/mysqldump-php/src/Ifsnop',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit90aca0b7a54f3a17976e1226fab7c664::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit90aca0b7a54f3a17976e1226fab7c664::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit90aca0b7a54f3a17976e1226fab7c664::$classMap;

        }, null, ClassLoader::class);
    }
}