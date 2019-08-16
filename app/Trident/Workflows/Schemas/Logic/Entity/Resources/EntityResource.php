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
