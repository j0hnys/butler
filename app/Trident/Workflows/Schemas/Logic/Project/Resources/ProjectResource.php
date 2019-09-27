<?php

namespace App\Trident\Workflows\Schemas\Logic\Project\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'name' => $this->name,
            'root_folder' => $this->root_folder,
            'relative_schemas_folder' => $this->relative_schemas_folder,
            'db_connection_name' => $this->db_connection_name,
        ];

        
        return parent::toArray($request);
    }

}
