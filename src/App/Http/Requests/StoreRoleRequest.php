<?php

namespace jeremykenedy\LaravelRoles\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use jeremykenedy\LaravelRoles\App\Http\Requests\Concerns\ChecksConfiguredAccess;

class StoreRoleRequest extends FormRequest
{
    use ChecksConfiguredAccess;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->passesConfiguredGate(
            config('roles.rolesGuiCreateNewRolesMiddlewareType'),
            config('roles.rolesGuiCreateNewRolesMiddleware')
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => 'required|unique:'.config('roles.rolesTable').',name,'.$this->id.',id',
            'slug'          => 'required|unique:'.config('roles.rolesTable').',slug,'.$this->id.',id',
            'description'   => 'nullable|string|max:255',
            'level'         => 'required|integer',
        ];
    }

    /**
     * Return the fields and values to create a new role.
     *
     * @return array
     */
    public function roleFillData()
    {
        return [
            'name'          => $this->name,
            'slug'          => $this->slug,
            'description'   => $this->description,
            'level'         => $this->level,
        ];
    }
}
