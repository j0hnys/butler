<?php

namespace App\Trident\Business\Schemas\Logic\Definition\Typed\Trident;

use j0hnys\Definitions\Definition;

final class Functionality extends Definition
{
    const schema = [
        "model" => [
            "db_name" => "T::string()"
        ],
    ];

    const endpoint = [
        "endpoint" => [
            "uri" => "T::string()",
            "group" => "{{endpoint_group}}",
            "type" => "{{endpoint_type}}"
        ]
    ];

    const endpoint_type = [
        'create', 'read', 'update', 'delete'
    ];
    const endpoint_group = [
        '', 'auth'
    ];
}

