<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3be2b0cf4daa3ad3e42a26444ae1bdfc
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3be2b0cf4daa3ad3e42a26444ae1bdfc::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3be2b0cf4daa3ad3e42a26444ae1bdfc::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
