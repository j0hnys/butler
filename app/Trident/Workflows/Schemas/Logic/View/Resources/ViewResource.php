<?php

namespace App\Trident\Workflows\Schemas\Logic\View\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ViewResource extends JsonResource
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
            'project_name' => $this->project->name,
            'definition_id' => $this->definition_id,
            'definition_namespace' => $this->definition->namespace,
            'entity_id' => $this->entity_id,
            'entity_name' => $this->entity->name,
            'name' => $this->name,
            'type' => $this->type,
            'presentation_data' => $this->presentation_data,
            'vista_resource_folder_name' => $this->vista_resource_folder_name,
        ];

        
        return parent::toArray($request);
    }

}
