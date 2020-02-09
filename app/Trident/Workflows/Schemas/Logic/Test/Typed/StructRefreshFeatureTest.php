<?php

namespace App\Trident\Workflows\Schemas\Logic\Test\Typed;

use App\Trident\Base\Typed\Structs\StructOptionalValues;
use J0hnys\Typed\T;

class StructrefreshFeatureTest extends StructOptionalValues
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

