<?php

namespace App\Trident\Business\Logic;

use App\Trident\Interfaces\Business\Logic\DefinitionInterface;
use App\Trident\Business\Schemas\Logic\Definition\Typed\SchemaHierarchy;
use App\Trident\Business\Schemas\Logic\Definition\Typed\Trident\Response;
use App\Trident\Business\Schemas\Logic\Definition\Typed\Vista\Form;

class Definition implements DefinitionInterface
{

    /**
     * constructor.
     *
     * @var string
     * @return void
     */
    public function __construct()
    {
       //
    }

    /**
     * *description goes here*.
     *
     * @var array
     * @return array
     */
    public function get(): array
    {

        // $tmp = new SchemaHierarchy();
        // $tmp->getFilledValues();

        // $tmp1 = new Form();
        // $tmp1->getFilledValues();

        $response = new Response();
        $response->check([
            "type" => 'json',
            "tmp" => 'a string',
            "tmp1" => 'EntityName',
            "data" => [
                "id" => [
                    'resource' => true,
                ]
            ],
        ]);

        dump([
            // '$tmp' => $tmp,
            // '$tmp1' => $tmp1,
            '$response' => $response,
        ]);

        return [];
    }


}
