<?php

namespace App\Trident\Workflows\Validations;

use Illuminate\Foundation\Http\FormRequest;
use Route;

class ProjectUpdateRequest extends FormRequest
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
            'name' => 'required | string',
            'root_folder' => 'required | string',
            'relative_schemas_folder' => 'required | string',
            'db_connection_name' => 'required | string',
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
            'user_id' => 'user_id is required',
            'name' => 'name is required',
            'root_folder' => 'root_folder is required',
            'relative_schemas_folder' => 'relative_schemas_folder is required',
            'db_connection_name' => 'db_connection_name is required',
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
        $data['id'] = (int)$this->route('project');
        $data['user_id'] = (int)auth()->user()->id;
        return $data;
    }

}