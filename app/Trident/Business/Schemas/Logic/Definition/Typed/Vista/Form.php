<?php

namespace App\Trident\Business\Schemas\Logic\Definition\Typed\Vista;

use App\Trident\Base\Typed\Definitions\Definition;
use J0hnys\Typed\T;

class Form extends Definition
{
    const schema = [
        "ajax" => [
            "get" => [
                "GET" => "T::string()"
            ],
            "create" => [
                "POST" => "T::string()"
            ],
            "update" => [
                "POST" => "T::string()"
            ],
            "delete" => [
                "DELETE" => "T::string()"
            ]
        ],
        "presentation" => [
            "type" => "form",
            "schema" => [
                [
                    "column_name" => "T::string()",
                    "column_type" => "{{column_type}}",
                    "type" => "{{element_type}}",
                    "validation_rules" => [
                        "required" => "T::bool()",
                        "type" => "{{validation_rule_type}}",
                        "trigger" => "{{validation_rule_trigger}}"
                    ],
                    "attributes" => [
                        "type" => [
                            "{{attributes_type_name}}" => "T::bool()"
                        ],
                        "default_value" => "{{attributes_default_value}}",
                        "element_type" => "T::bool()"
                    ]
                ]
            ]
        ]
    ];

    const column_type = [
        'string', 'integer'
    ];

    const element_type = [
        'fillable'
    ];

    const validation_rule_type = [
        'string', 'number'
    ];

    const validation_rule_trigger = [
        'blur'
    ];

    const attributes_default_value = 'T::string()';

    const attributes_type_name = [
        'string', 'number'
    ];


    public function __construct($data = [])
    {
        $this->types = [
            'ajax' => T::array(),
            'presentation' => T::array(),
        ];
        
        parent::__construct($this->types);

        $this->set(self::schema);
    }


}

