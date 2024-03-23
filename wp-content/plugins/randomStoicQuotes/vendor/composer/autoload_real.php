<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit33f8d7dffc2d8290b67530d765240aba
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInit33f8d7dffc2d8290b67530d765240aba', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit33f8d7dffc2d8290b67530d765240aba', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit33f8d7dffc2d8290b67530d765240aba::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}