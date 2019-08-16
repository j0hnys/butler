<?php

namespace App\Trident\Business\Schemas\Logic\Definition\Typed\Trident;

use App\Trident\Base\Typed\Definitions\Definition;
use J0hnys\Typed\T;

class Functionality extends Definition
{
    const schema = [
        "model" => [
            "db_name" => "T::string()"
        ],
    ];

    public function __construct($data = [])
    {
        $this->types = [
            'model' => T::array(),
        ];
        
        parent::__construct($this->types);

        $this->set(self::schema);
    }

    
}

