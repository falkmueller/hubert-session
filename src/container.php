<?php

namespace hubert\extension\session;

use Zend\Session\Container as SessionContainer;

class container extends SessionContainer {
    
    public function get($name, $default = null){
        if(isset($this[$name])){
            return $this[$name];
        }
        
        return $default;
    }
    
}
