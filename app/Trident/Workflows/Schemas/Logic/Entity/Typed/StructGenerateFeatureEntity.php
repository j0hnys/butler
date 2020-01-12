<?php

namespace App\Trident\Workflows\Schemas\Logic\Entity\Typed;

use App\Trident\Base\Typed\Structs\StructOptionalValues;
use J0hnys\Typed\T;

class StructgenerateFeatureEntity extends StructOptionalValues
{
    public function __construct($data = [])
    {
        $this->types = [
            'id' => T::nullable(T::int()),
            'user_id' => T::nullable(T::int()),
        ];
        
        parent::__construct($this->types);

        $this->set($data);
    }
}

