<?php

namespace App\Trident\Business\Schemas\Logic\Definition\Typed\Trident;

use App\Trident\Base\Typed\Definitions\Definition;

final class Response extends Definition
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
}

