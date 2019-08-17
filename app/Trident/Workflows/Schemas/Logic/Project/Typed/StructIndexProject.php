<?php

namespace App\Trident\Workflows\Schemas\Logic\Project\Typed;

use App\Trident\Base\Typed\Structs\StructOptionalValues;
use J0hnys\Typed\T;

class StructindexProject extends StructOptionalValues
{
    public function __construct($data = [])
    {
        $this->types = [
            'id' => T::nullable(T::int()),
            'user_id' => T::nullable(T::int()),
            'name' => T::nullable(T::string()),
            'root_folder' => T::nullable(T::string()),
            'relative_schemas_folder' => T::nullable(T::string()),
            'db_connection_name' => T::nullable(T::string()),
        ];
        
        parent::__construct($this->types);

        $this->set($data);
    }
}

