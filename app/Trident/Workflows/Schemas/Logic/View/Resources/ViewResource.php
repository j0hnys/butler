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
            'definition_id' => $this->definition_id,
            'entity_id' => $this->entity_id,
            'name' => $this->name,
            'type' => $this->type,
            'presentation_data' => $this->presentation_data,
            'vista_resource_folder_name' => $this->vista_resource_folder_name,
        ];

        // return [
        //     'id' => $this->id,
        //     'name' => $this->name,
        //     'email' => $this->email,
        //     'posts' => PostResource::collection($this->whenLoaded('posts')),    
        //     'somekey' => $this->getSomeTransformation(); 
        //     'created_at' => $this->created_at,
        //     'updated_at' => $this->updated_at,
        // ];

        return parent::toArray($request);
    }

}
