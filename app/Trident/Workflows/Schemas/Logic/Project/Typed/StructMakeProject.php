<?php

namespace App\Trident\Workflows\Schemas\Logic\Project\Typed;

use App\Trident\Base\Typed\Structs\StructOptionalValues;
use J0hnys\Typed\T;

class StructmakeProject extends StructOptionalValues
{
    public function __construct($data = [])
    {
        $this->types = [
            //
        ];
        
        parent::__construct($this->types);

        $this->set($data);
    }
}

