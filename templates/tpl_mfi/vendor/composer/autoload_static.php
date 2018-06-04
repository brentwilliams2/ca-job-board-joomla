<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit22e62383002c688a458e99afb952a0c0
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Phproberto\\Sass\\' => 16,
        ),
        'L' => 
        array (
            'Leafo\\ScssPhp\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Phproberto\\Sass\\' => 
        array (
            0 => __DIR__ . '/..' . '/phproberto/sass/src',
        ),
        'Leafo\\ScssPhp\\' => 
        array (
            0 => __DIR__ . '/..' . '/leafo/scssphp/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit22e62383002c688a458e99afb952a0c0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit22e62383002c688a458e99afb952a0c0::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
