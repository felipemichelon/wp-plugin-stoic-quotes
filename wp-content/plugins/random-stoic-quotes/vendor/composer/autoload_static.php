<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6667cc586ea13d6b546476fcf7076c1c
{
    public static $prefixLengthsPsr4 = array (
        'I' => 
        array (
            'Inc\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Inc\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6667cc586ea13d6b546476fcf7076c1c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6667cc586ea13d6b546476fcf7076c1c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit6667cc586ea13d6b546476fcf7076c1c::$classMap;

        }, null, ClassLoader::class);
    }
}