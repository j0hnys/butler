<?php

namespace App\Trident\Business\Schemas\Logic\Definition\Typed;

use App\Trident\Base\Typed\Definitions\Definition;
use J0hnys\Typed\T;

class SchemaHierarchy extends Definition
{
    const hierarchy = [
        'trident-vista' => [
            '{{entity_name}}' => [
                'Presentation',
                'Processes',
                'Resources' => [
                    'Functionality.json',
                    'Request.json',
                    'Response.json',
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

