<?php

return array(
    "factories" => array(
         "session" => array(hubert\extension\session\factory::class, 'get')
        ),
    
    "config" => array(
        "session" => array(
            'remember_me_seconds' => 1800,
            'name'                => 'zf2',
        )
    )
);
