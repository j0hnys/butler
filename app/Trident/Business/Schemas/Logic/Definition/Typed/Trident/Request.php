<?php

namespace App\Trident\Business\Schemas\Logic\Definition\Typed\Trident;

use App\Trident\Base\Typed\Definitions\Definition;
use J0hnys\Typed\T;

class Request extends Definition
{
    const schema = [
        "type" => '{{request_type}}',
        "data" => [
            "{{entity_property}}" => [
                'type' => 'T::string()',
                'validation' => [
                    'rule' => '{{laravel_validation_rule_string}}',
                    'message' => 'T::string()',
                ],
                'fillable' => 'T::bool()',
            ]
        ],
    ];

    const request_type = [
        'json'
    ];

    const entity_property = 'T::string()';

    const laravel_validation_rule_string = 'T::string()';

    
}

