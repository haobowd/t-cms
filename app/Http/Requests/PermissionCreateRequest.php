<?php

namespace App\Http\Requests;

class PermissionCreateRequest extends Request
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
            'name' => 'required:unique:permissions',
            'display_name' => 'nullable|string',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|int',
            'is_menu' => 'nullable|boolean',
            'icon' => 'nullable|string',
            'order' => 'nullable|int'
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
