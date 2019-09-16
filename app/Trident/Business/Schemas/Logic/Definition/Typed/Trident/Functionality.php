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
}

