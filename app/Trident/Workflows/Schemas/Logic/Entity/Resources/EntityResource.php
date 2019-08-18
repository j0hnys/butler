<?php

namespace App\Trident\Workflows\Schemas\Logic\Entity\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EntityResource extends JsonResource
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
            'id' => $this->id,
            'project_id' => $this->project_id,
            'definition_id' => $this->definition_id,
            'name' => $this->name,
            'functionality_data' => $this->functionality_data,
            'request_data' => $this->request_data,
            'response_data' => $this->response_data,
            'db_table_name' => $this->db_table_name,
        ];

        return parent::toArray($request);
    }

}
