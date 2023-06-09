<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdfddc2e325adfa32612d3adcaa0544ba
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'MF\\' => 3,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'MF\\' => 
        array (
            0 => __DIR__ . '/..' . '/MF',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitdfddc2e325adfa32612d3adcaa0544ba::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdfddc2e325adfa32612d3adcaa0544ba::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitdfddc2e325adfa32612d3adcaa0544ba::$classMap;

        }, null, ClassLoader::class);
    }
}
