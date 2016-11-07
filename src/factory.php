<?php

namespace hubert\extension\session;

use Zend\Session\Config\StandardConfig;
use Zend\Session\SessionManager;
use hubert\extension\session\container as Container;

class factory {
    
    private $container;
    
    function __construct($container){
        $this->container = $container;
    }


    public static function get($container){
        $facory = new static($container);
        $facory->init();
        
        return function ($sessionnamespace = "default") {
            return new Container($sessionnamespace);
        };
    }
    
    public function init(){
        $sessionManager = $this->getSessionManager();
        Container::setDefaultManager($sessionManager);
        
        $sessionManager->start();
        
        $container = new Container('initialized');

        if (!isset($container->init)) {
            $container->init = 1;
            $container->remoteAddr    = $_SERVER['REMOTE_ADDR'];
            $container->httpUserAgent = $_SERVER['HTTP_USER_AGENT'];
        }
                
        $config = $this->container["config"]["session"];

        if(isset($config['validate_user_agend']) && !empty($config['validate_user_agend'])){
            if($_SERVER['HTTP_USER_AGENT'] !== $container->httpUserAgent){
                $sessionManager->destroy(["clear_storage" => true]);
                return;
            }
        }
        
        if(isset($config['validate_remote_addr']) && !empty($config['validate_remote_addr'])){
           if($_SERVER['REMOTE_ADDR'] !== $container->remoteAddr){
                $sessionManager->destroy(["clear_storage" => true]);
                return;
            }
        }
    }
    
    private function getSessionManager(){
        $config = new StandardConfig();
        $config->setOptions($this->container["config"]["session"]);
        $manager = new SessionManager($config);
        
        return $manager;
    }
    
    
}
