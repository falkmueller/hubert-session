Hubert Session Extension
======

## Installation

Hubert is available via Composer:

```json
{
    "require": {
        "falkm/hubert-session": "1.*"
    }
}
```

## Usage

Create an index.php file with the following contents:

```php
<?php

require 'vendor/autoload.php';

$app = new hubert\app();

$config = array(
    "factories" => array(
         "session" => array(hubert\extension\session\factory::class, 'get')
        ),
    "config" => array(
        "display_errors" => true,     
        "session" => array(
                'remember_me_seconds' => 1800,
                'name'                => 'zf2',
            ),
        ),
    "routes" => array(
            "home" => array(
                "route" => "/", 
                "method" => "GET|POST", 
                "target" => function($request, $response, $args){
                    $container = hubert()->container();     
                    if (isset($container->session()->name)){
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
                    $container = hubert()->container();     
                    $name = $args["name"];
                    $container->session()->name = $name;
                    echo "Name {$name} are set in session.<br/>";
                    $link = $container["router"]->get("home");
                        echo "<a href='{$link}'>retrun</a>";
                })
        ),
);

hubert($config);
hubert()->emit(hubert()->run());
```

For more see the example in this repository.

### components

- zend session [zendframework/zend-session](https://docs.zendframework.com/zend-session/)

## License

The MIT License (MIT). Please see [License File](https://github.com/falkmueller/hubert/blob/master/LICENSE) for more information.