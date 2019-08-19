<?php

namespace App\Trident\Business\Schemas\Logic\Definition\Typed;

use App\Trident\Base\Typed\Definitions\Definition;
use J0hnys\Typed\T;

class SchemaHierarchy extends Definition
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

    public function __construct($data = [])
    {
        $this->types = [
            'trident-vista' => T::array(),
        ];
        
        parent::__construct($this->types);

        $this->set(self::hierarchy);
    }
    

}

