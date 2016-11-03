<?php
return array(
    
   "config" => array(
        "display_errors" => true,   
    ),
    "routes" => array(
            "home" => array(
                "route" => "/", 
                "method" => "GET|POST", 
                "target" => function($request, $response, $args){
                    $container = $this->getContainer();
                    
                    if (isset($container["session"]()->name)){
                        echo "Hello, ".$container["session"]()->name;
                    } else {
                        $link = $container["router"]->get("setName", ["name" => "hubert"]);
                        echo "call <a href='{$link}'>Set Name</a>";
                    }
                }
            ),
            "setName" => array(
                "route" => "/name/[:name]", 
                "method" => "GET|POST", 
                "target" => function($request, $response, $args){
                    $container = $this->getContainer();
                
                    $name = $args["name"];
                    $container["session"]()->name = $name;
                    echo "Name {$name} are set in session.<br/>";
                    $link = $container["router"]->get("home");
                        echo "<a href='{$link}'>retrun</a>";
                })
        )
);
