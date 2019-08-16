<?php

namespace App\Trident\Business\Schemas\Logic\Definition\Typed\Trident;

use App\Trident\Base\Typed\Definitions\Definition;
use J0hnys\Typed\T;

class Response extends Definition
{
    const schema = [
        "type" => '{{request_type}}',
        "data" => [
            "{{entity_property}}" => [
                'resource' => 'T::bool()',
            ]
        ],
    ];

    const request_type = [
        'json'
    ];

    const entity_property = 'T::string()';


    public function __construct()
    {
        $this->types = [
            'type' => T::string(),
            'data' => T::array(),
        ];
        
        parent::__construct($this->types);

        $this->set(self::schema);
    }
    
}

