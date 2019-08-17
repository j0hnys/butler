<?php

namespace App\Trident\Workflows\Schemas\Logic\Entity\Typed;

use App\Trident\Base\Typed\Structs\StructOptionalValues;
use J0hnys\Typed\T;

class StructindexEntity extends StructOptionalValues
{
    public function __construct($data = [])
    {
        $this->types = [
            'id' => T::nullable(T::int()),
            'user_id' => T::nullable(T::int()),
            'project_id' => T::nullable(T::int()),
            'definition_id' => T::nullable(T::int()),
            'name' => T::nullable(T::string()),
            'functionality_data' => T::nullable(T::string()),
            'request_data' => T::nullable(T::string()),
            'response_data' => T::nullable(T::string()),
        ];
        
        parent::__construct($this->types);

        $this->set($data);
    }
}

