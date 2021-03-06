<?php

namespace App\Trident\Workflows\Schemas\Logic\Definition\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GetDefaultDefinitionValuesResource extends JsonResource
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
            'request_table_data' => $this->request_table_data,
            'response_table_data' => $this->response_table_data,
            'presentation_table_data' => $this->presentation_table_data,
            'tests_request_table_data' => $this->tests_request_table_data,
            'tests_response_table_data' => $this->tests_response_table_data,
        ];

        return parent::toArray($request);
    }

}
