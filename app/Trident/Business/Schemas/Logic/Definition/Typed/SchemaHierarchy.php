<?php

namespace App\Trident\Business\Schemas\Logic\Definition\Typed;

use App\Trident\Base\Typed\Definitions\Definition;

final class SchemaHierarchy extends Definition
{
    const hierarchy = [
        'trident-vista' => [
            '{{entity_name}}' => [
                'Presentation' => [
                    '@\App\Trident\Business\Schemas\Logic\Definition\Typed\Vista\Form',
                ],
                'Processes',
                'Resource' => [
                    '@\App\Trident\Business\Schemas\Logic\Definition\Typed\Trident\Functionality',
                    '@\App\Trident\Business\Schemas\Logic\Definition\Typed\Trident\Request',
                    '@\App\Trident\Business\Schemas\Logic\Definition\Typed\Trident\Response',
                ]
            ],
        ],
    ];

    const entity_name = 'T::string()';
}

