<?php

/**
 * @package RandomStoicQuotes
 */

namespace Inc;

if (!class_exists('rsqInit')) {
    final class rsqInit
    {
        public static function register_services()
        {
            foreach (self::get_services() as $class) {
                $service = self::instantiate($class);
                if (method_exists($service, 'register')) {
                    $service->register();
                }
            }
        }

        public static function get_services()
        {
            return [
                randomStoicQuotes::class,
                rsqActivate::class,
                rsqPluginMenu::class,
                rsqConfiguration::class,
            ];
        }

        public static function instantiate($class)
        {
            return new $class;
        }
    }
}
