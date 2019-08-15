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
