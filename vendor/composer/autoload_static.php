<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc7e20a1cb4cf3e6701555cf5e92924cc
{
    public static $files = array (
        'decc78cc4436b1292c6c0d151b19445c' => __DIR__ . '/..' . '/phpseclib/phpseclib/phpseclib/bootstrap.php',
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'p' => 
        array (
            'phpseclib\\' => 10,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Component\\HttpFoundation\\' => 33,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'phpseclib\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpseclib/phpseclib/phpseclib',
        ),
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Component\\HttpFoundation\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/http-foundation',
        ),
    );

    public static $prefixesPsr0 = array (
        'l' => 
        array (
            'litle\\sdk' => 
            array (
                0 => __DIR__ . '/..' . '/litle/payments-sdk',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc7e20a1cb4cf3e6701555cf5e92924cc::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc7e20a1cb4cf3e6701555cf5e92924cc::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitc7e20a1cb4cf3e6701555cf5e92924cc::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}