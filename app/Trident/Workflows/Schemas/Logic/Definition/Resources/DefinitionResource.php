<?php

namespace App\Trident\Workflows\Schemas\Logic\Definition\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DefinitionResource extends JsonResource
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
            'namespace' => $this->namespace,
        ];

        
        return parent::toArray($request);
    }

}
