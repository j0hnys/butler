<?php

namespace App\Trident\Base\Typed\Definitions;

use App\Trident\Base\Typed\Structs\StructOptionalValues;
use J0hnys\Typed\T;
use J0hnys\Typed\Struct;

class Definition extends StructOptionalValues
{

    public function check($data = [], $haystack = null)
    {
        $className = get_class($this);
        $oClass = new \ReflectionClass($className);
        $constants = $oClass->getConstants();

        if ($haystack === null) {
            $haystack = $constants['schema'];
        }

        foreach ($haystack as $key => $value) {
            if (!isset($data[$key]) && strpos($key, '{{') === false) {
                throw new \Exception('data key: '.$key.' is not set', 1);
            }

            if (is_array($value)) {
                if (strpos($key, '{{') === false) {
                    $this->check( $data[$key], $haystack[$key] );
                } else {
                    $array_values = array_values($data);
                    foreach ($array_values as $array_value) {
                        $this->check( $array_value, $haystack[$key] );
                    }
                }
            }

            if (strpos($key, '{{') !== false) {
                $definition_type_name = str_replace('{{','',$key);
                $definition_type_name = str_replace('}}','',$definition_type_name);

                $definition_type = $constants[$definition_type_name];
                
                $array_keys = array_keys($data);

                if (is_array($definition_type)) {
                    foreach ($array_keys as $array_key) {
                        if (!in_array($array_key, $definition_type)) {
                            throw new \Exception("unknown type", 1);
                        }
                    }
                } else if (strpos($definition_type, 'T::') !== false) {
                    $definition_type = str_replace('T::', T::class.'::', $definition_type);
                    $result = eval('return '.$definition_type.';');

                    $struct_check = new Struct([
                        'value' => $result,
                    ]);

                    foreach ($array_keys as $array_key) {
                        $struct_check->set([
                            'value' => $array_key
                        ]);
                    }
                }
            }

            if (is_string($value)) {
                if (strpos($value, '{{') !== false) {
                    $definition_type_name = str_replace('{{','',$value);
                    $definition_type_name = str_replace('}}','',$definition_type_name);
    
                    $definition_type = $constants[$definition_type_name];

                    if (is_array($definition_type)) {
                        if (!in_array($data[$key], $definition_type)) {
                            throw new \Exception("unknown type", 1);
                        }
                    } else if (strpos($definition_type, 'T::') !== false) {
                        $definition_type = str_replace('T::', T::class.'::', $definition_type);
                        $result = eval('return '.$definition_type.';');

                        $struct_check = new Struct([
                            'value' => $result,
                        ]);
    
                        $struct_check->set([
                            'value' => $data[$key]
                        ]);
                    }    
                } else if (strpos($value, 'T::') !== false) {
                    $value = str_replace('T::', T::class.'::', $value);
                    $result = eval('return '.$value.';');

                    $struct_check = new Struct([
                        'value' => $result,
                    ]);

                    $struct_check->set([
                        'value' => $data[$key]
                    ]);
                }
            }
        }
    }


    /**
     * @return array
     */
    public function get(): array {
        $className = get_class($this);
        $oClass = new \ReflectionClass($className);
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

