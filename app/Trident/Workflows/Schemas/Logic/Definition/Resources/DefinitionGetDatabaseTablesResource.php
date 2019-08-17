<?php

namespace App\Trident\Workflows\Schemas\Logic\Definition\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DefinitionGetDatabaseTablesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'table_names' => $this->table_names
        ];

        return parent::toArray($request);
    }

}
