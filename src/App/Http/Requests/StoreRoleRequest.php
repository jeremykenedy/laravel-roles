<?php

namespace jeremykenedy\LaravelRoles\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (config('roles.rolesGuiCreateNewRolesMiddlwareType') == 'role') {
            return $this->user()->hasRole(config('roles.rolesGuiCreateNewRolesMiddlware'));
        }
        if (config('roles.rolesGuiCreateNewRolesMiddlwareType') == 'permissions') {
            return $this->user()->hasPermission(config('roles.rolesGuiCreateNewRolesMiddlware'));
        }
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

            'name'          => 'required|string|max:255|unique:'.config('roles.rolesTable').',id,'.$this->id,
            'slug'          => 'required|string|max:255|unique:'.config('roles.rolesTable').',id,'.$this->id,
            'description'   => 'nullable|string|max:255',
            'level'         => 'required|integer',
        ];
    }

    /**
     * Return the fields and values to create a new role.
     *
     * @return array
     */
    public function postFillData()
    {
        return [
            'name'          => $this->name,
            'slug'          => $this->slug,
            'description'   => $this->description,
            'level'         => $this->level,
        ];
    }
}
