<?php

declare(strict_types=1);

namespace jeremykenedy\LaravelRoles\App\Services;

use Illuminate\Support\Arr;
use jeremykenedy\LaravelRoles\Traits\RolesAndPermissionsHelpersTrait;

class PermissionFormFields
{
    use RolesAndPermissionsHelpersTrait;

    /**
     * The id of the permission being edited, or null when creating.
     *
     * @var int|string|null
     */
    protected $id;

    /**
     * List of fields and default value for each field.
     *
     * @var array
     */
    protected $fieldList = [
        'name'          => '',
        'slug'          => '',
        'description'   => '',
        'model'         => '',
    ];

    /**
     * Create a new form fields instance.
     *
     * @param int|string|null $id
     */
    public function __construct($id = null)
    {
        $this->id = $id;
    }

    /**
     * Build the form field data.
     *
     * @return array
     */
    public function handle()
    {
        $fields = $this->fieldList;

        if ($this->id) {
            $fields = $this->fieldsFromModel($this->id, $fields);
        }

        foreach ($fields as $fieldName => $fieldValue) {
            $fields[$fieldName] = old($fieldName, $fieldValue);
        }

        return array_merge(
            $fields,
            $this->permissionFormFieldData()
        );
    }

    /**
     * Return the field values from the model.
     *
     * @param int|string $id
     *
     * @return array
     */
    protected function fieldsFromModel($id, array $fields)
    {
        $permission = config('roles.models.permission')::findOrFail($id);

        $fieldNames = array_keys(Arr::except($fields, ['permissions']));

        $fields = [
            'id' => $id,
        ];

        foreach ($fieldNames as $field) {
            $fields[$field] = $permission->{$field};
        }

        return $fields;
    }

    /**
     * Get the additional form fields data.
     *
     * @return array
     */
    protected function permissionFormFieldData()
    {
        return [
            'permissionModels' => $this->getPermissionModels(),
        ];
    }
}
