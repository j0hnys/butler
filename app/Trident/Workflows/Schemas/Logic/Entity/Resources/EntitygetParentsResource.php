<?php

namespace App\Trident\Workflows\Schemas\Logic\Entity\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EntitygetParentsResource extends JsonResource
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
            'project_name' => $this->project_name,
            'definition_id' => $this->definition_id,
            'definition_namespace' => $this->definition_namespace,
            'entity_id' => $this->entity_id,
            'entity_name' => $this->entity_name,
            'parent_id' => $this->parent_id,
            'name' => $this->name,
            'type' => $this->type,
            'functionality_data' => $this->functionality_data,
            'request_data' => $this->request_data,
            'response_data' => $this->response_data,
        ];

        
        return parent::toArray($request);
    }

}
