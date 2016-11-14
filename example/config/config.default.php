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
                    if (isset(hubert()->session()->name)){
                        echo "Hello, ".hubert()->session()->name;
                    } else {
                        $link = hubert()->router->get("setName", ["name" => "hubert"]);
                        echo "call <a href='{$link}'>Set Name</a>";
                    }
                }
            ),
            "setName" => array(
                "route" => "/name/[:name]", 
                "method" => "GET|POST", 
                "target" => function($request, $response, $args){
                    $name = $args["name"];
                    hubert()->session()->name = $name;
                    echo "Name {$name} are set in session.<br/>";
                    $link = hubert()->router->get("home");
                        echo "<a href='{$link}'>retrun</a>";
                })
        )
);
