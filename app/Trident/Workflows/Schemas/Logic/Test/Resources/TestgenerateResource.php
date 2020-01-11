<?php

namespace App\Trident\Workflows\Schemas\Logic\Test\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TestgenerateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        
        return parent::toArray($request);
    }

}
