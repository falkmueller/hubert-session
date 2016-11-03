<?php

namespace hubert\extension\session;

use Zend\Session\Config\StandardConfig;
use Zend\Session\SessionManager;
use Zend\Session\Container as SessionContainer;

class factory {
    public static function get($container){
        $config = new StandardConfig();
        $config->setOptions($container["config"]["session"]);
        $manager = new SessionManager($config);
        SessionContainer::setDefaultManager($manager);
        $manager->start();
        return function ($sessionnamespace = "default") {
            return new SessionContainer($sessionnamespace);
        };
    }
}
