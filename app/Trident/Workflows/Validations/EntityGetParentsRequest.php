<?php

namespace App\Trident\Workflows\Validations;

use Illuminate\Foundation\Http\FormRequest;
use Route;

class EntityGetParentsRequest extends FormRequest
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
        $data['id'] = (int)$this->route('entity');
        $data['user_id'] = (int)auth()->user()->id;
        return $data;
    }

}