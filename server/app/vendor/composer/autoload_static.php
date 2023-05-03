<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit65c61f52c91eb34f5a1f3233df01035b
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

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit65c61f52c91eb34f5a1f3233df01035b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit65c61f52c91eb34f5a1f3233df01035b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit65c61f52c91eb34f5a1f3233df01035b::$classMap;

        }, null, ClassLoader::class);
    }
}