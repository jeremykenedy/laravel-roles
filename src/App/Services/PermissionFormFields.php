<?php

namespace jeremykenedy\LaravelRoles\App\Services;

use jeremykenedy\LaravelRoles\Traits\RolesAndPermissionsHelpersTrait;

class PermissionFormFields
{
    use RolesAndPermissionsHelpersTrait;

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
     * Create a new job instance.
     *
     * @param int $id
     *
     * @return void
     */
    public function __construct($id = null)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
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

        // Get the additional data for the form fields
        $permissionFormFieldData = $this->permissionFormFieldData();

        return array_merge(
            $fields,
            $permissionFormFieldData
        );

        return $fields;
    }

    /**
     * Return the field values from the model.
     *
     * @param int   $id
     * @param array $fields
     *
     * @return array
     */
    protected function fieldsFromModel($id, array $fields)
    {
        $permission = config('roles.models.permission')::findOrFail($id);

        $fieldNames = array_keys(array_except($fields, ['permissions']));

        $fields = [
            'id' => $id,
        ];
        foreach ($fieldNames as $field) {
            $fields[$field] = $permission->{$field};
        }

        return $fields;
    }

    /**
     * Get the additonal form fields data.
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
