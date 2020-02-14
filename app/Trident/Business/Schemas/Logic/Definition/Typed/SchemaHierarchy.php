<?php

namespace App\Trident\Business\Schemas\Logic\Definition\Typed;

use j0hnys\Definitions\Definition;

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
                ],
                'Features' => [
                    '{{feature_name}}' => [
                        '@\App\Trident\Business\Schemas\Logic\Definition\Typed\Trident\Functionality',
                        '@\App\Trident\Business\Schemas\Logic\Definition\Typed\Trident\Request',
                        '@\App\Trident\Business\Schemas\Logic\Definition\Typed\Trident\Response',
                    ]
                ],
                'Tests' => [
                    '@\App\Trident\Business\Schemas\Logic\Definition\Typed\Trident\Tests\Functionality',
                    '@\App\Trident\Business\Schemas\Logic\Definition\Typed\Trident\Tests\Request',
                    '@\App\Trident\Business\Schemas\Logic\Definition\Typed\Trident\Tests\Response',
                ]
            ],
        ],
    ];

    const entity_name = 'T::string()';
    const feature_name = 'T::string()';
}

