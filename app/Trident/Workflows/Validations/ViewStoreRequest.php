<?php

namespace App\Trident\Workflows\Validations;

use Illuminate\Foundation\Http\FormRequest;
use Route;

class ViewStoreRequest extends FormRequest
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
            'project_id' => 'required | integer',
            'definition_id' => 'required | integer',
            'entity_id' => 'required | integer',
            'name' => 'required | string',
            'type' => 'required | string',
        ];

        // return [
        //     // 'id' => 'required',
        //     'string_parameter' => 'string',
        //     'integer_parameter' => 'integer',
        // ];  //<-- when [] there is no validation.
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
            'project_id' => 'project_id is required',
            'definition_id' => 'definition_id is required',
            'entity_id' => 'entity_id is required',
            'name' => 'name is required',
            'type' => 'type is required',
        ];

        // return [
        //     // 'id.required' => 'id is required!!',
        //     'string_parameter.required' => 'string_parameter is required!!',
        //     'string_parameter.string' => 'string_parameter must be string!!',
        //     'integer_parameter.integer' => 'integer_parameter must be integer!!',
        // ];  //<-- when [] there is no validation.
    }

    /**
     * Add parameters to be validated (for GET parameters)
     * 
     * @return array
     */
    public function all($keys = null) 
    {
        $data = parent::all($keys);
        $data['id'] = (int)$this->route('view');
        $data['user_id'] = (int)auth()->user()->id;
        return $data;
    }

}