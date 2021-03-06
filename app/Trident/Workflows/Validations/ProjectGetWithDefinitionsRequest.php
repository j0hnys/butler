<?php

namespace App\Trident\Workflows\Validations;

use Illuminate\Foundation\Http\FormRequest;
use Route;

class ProjectGetWithDefinitionsRequest extends FormRequest
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
            //
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
            //
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
        $data['id'] = (int)$this->route('project');
        $data['user_id'] = (int)auth()->user()->id;
        return $data;
    }

}