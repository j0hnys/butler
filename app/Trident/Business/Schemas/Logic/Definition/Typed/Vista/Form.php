<?php

namespace App\Trident\Business\Schemas\Logic\Definition\Typed\Vista;

use App\Trident\Base\Typed\Structs\StructOptionalValues;
use J0hnys\Typed\T;

class Form extends StructOptionalValues
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
                            "string" => "T::bool()"
                        ],
                        "default_value" => "{{attributes_default_value}}",
                        "element_type" => "T::bool()"
                    ]
                ]
            ]
        ]
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

    /**
     * @return array
     */
    public function get(): array {
        $oClass = new \ReflectionClass(__CLASS__);
        $constants = $oClass->getConstants();

        return $constants;
    }

    /**
     * @param [type] $needle
     * @param [type] $haystack
     * @param boolean $strict
     * @param array $path
     * @return array|bool
     */
    private function arraySearchRecursive($needle, $haystack, $strict = false, $path = [])
    {
        if ( !is_array($haystack) ) {
            return [];
        }
    
        foreach($haystack as $key => $value ) {
            if (is_array($value) && $subPath = $this->arraySearchRecursive($needle, $value, $strict, $path) ) {
                // $path = array_merge($path, [$value], $subPath);
                $path = array_merge($path, [$value]);
                return $path;
            } else if ( (!$strict && strpos($key, strtoupper($needle)) !== false ) || ($strict && $key === $needle) ) {
                $path []= $key;
                return $path;
            }
        }

        return [];
    }


    /**
     * @param string $constant
     * @return array
     */
    public function search(string $constant, bool $strict = false): array
    {
        $all_constants = $this->get();

        $result = [];
        foreach ($all_constants as $key => $value) {
            $result[$key] = $this->arraySearchRecursive($constant, ["$key" => $value], $strict);
            if (!empty($result[$key])) {
                $result[$key] = $result[$key][0];
            }
        }        

        return $result;
    }

    /**
     * @param string $constant
     * @return boolean
     */
    public function exist(string $constant, bool $strict = true): bool
    {
        $result = $this->search($constant, $strict);

        $exist = false;
        foreach ($result as $element) {
            if (!empty($element)) {
                $exist = true;
                break;
            }
        }

        return $exist;
    }

}

