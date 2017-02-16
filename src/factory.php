<?php

namespace hubert\extension\session;

use Zend\Session\Config\StandardConfig;
use Zend\Session\SessionManager;
use hubert\extension\session\container as Container;

class factory {
    
    public static function get($container){
        $facory = new static();
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
            $container->httpUserAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
        }
                
        $config = hubert()->config()->session;

        if(isset($config['validate_user_agend']) && !empty($config['validate_user_agend'])){
            if((isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "") !== $container->httpUserAgent){
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
        $config->setOptions(hubert()->config()->session);
        $manager = new SessionManager($config);
        
        return $manager;
    }
    
    
}
