<?php

namespace App\Trident\Workflows\Validations;

use Illuminate\Foundation\Http\FormRequest;
use Route;

class TestStoreRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required | integer',
            'user_id' => 'integer',
            'project_id' => 'required | integer',
            'definition_id' => 'required | integer',
            'entity_id' => 'required | integer',
            'parent_id' => 'required | integer',
            'name' => 'required | string',
            'type' => 'required | string',
            'functionality_data' => 'required | string',
            'request_data' => 'required | string',
            'response_data' => 'required | string',
        ];
    }

     /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'id' => 'id is required',
            'user_id' => '',
            'project_id' => 'project_id is required',
            'definition_id' => 'definition_id is required',
            'entity_id' => 'entity_id is required',
            'parent_id' => 'parent_id is required',
            'name' => 'name is required',
            'type' => 'type is required',
            'functionality_data' => 'functionality_data is required',
            'request_data' => 'request_data is required',
            'response_data' => 'response_data is required',
        ];
    }

    /**
     * Add parameters to be validated (for GET parameters)
     * 
     * @return array
     */
    public function all($keys = null) 
    {
        $data = parent::all($keys);
        $data['id'] = (int)$this->route('test');
        $data['user_id'] = (int)auth()->user()->id;
        return $data;
    }

}