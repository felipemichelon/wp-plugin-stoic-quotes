<?php

/**
 * @package RandomStoicQuotes
 */

namespace Inc;

if ( ! class_exists( 'RsqInit' ) ) {
    final class RsqInit
    {
        public static function register_services()
        {
            foreach(self::get_services() as $class){
                $service = self::instantiate($class);
                if(method_exists($service, 'register')){
                    $service->register();
                }
            }
        }
    
        public static function get_services()
        {
            return [
                RandomStoicQuotesClasses\RsqAdmin::class,
                RandomStoicQuotesClasses\RsqConfiguration::class,
                RandomStoicQuotesClasses\RandomStoicQuotes::class,
            ];
        }
    
        public static function instantiate($class)
        {
            return new $class;
        }
    }
}
