<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel Roles Language Lines - laravelblocker
    |--------------------------------------------------------------------------
    */

    'date-format' => 'm/d/Y H:ia',

    'titles' => [
        'dashboard'             => 'Roles Dashboard',
        'show-role'             => 'Showing Role: <strong>:name</strong>',
        'show-permission'       => 'Showing Permission: <strong>:name</strong>',
        'roles-table'           => 'Active Roles',
        'roles-card'            => 'Roles',
        'role-card'             => 'Role: ',
        'permissions-card'      => 'Permissions',
        'permissions-table'     => 'Active Permissions',
        'dropdown-menu-alt'     => 'Show Roles Dropdown Menu',
        'create-role'           => 'Create New Role',
        'edit-role'             => 'Editing Role: <strong>:name</strong>',
        'create-permission'     => 'Create New Permission',
        'edit-permission'       => 'Editing Permission: <strong>:name</strong>',
        'roles-deleted-table'   => 'Deleted Roles',
    ],

    'cards' => [
        'users-count'       => '{1} :count user|[2,*] :count users',
        'permissions-count' => '{1} :count permission|[2,*] :count permissions',
        'roles-count'       => '{1} :count role|[2,*] :count roles',
        'none-count'        => 'None',
        'level'             => 'Level :level',
        'role-card'         => [
            'user-id'                   => 'User Id',
            'user-name'                 => 'Username',
            'user-email'                => 'User Email',
            'permissions-id'            => 'Permission Id',
            'permissions-name'          => 'Permission Name',
            'table-users-caption'       => 'Users with role: <strong><em>:role</em></strong>',
            'table-permissions-caption' => 'Permissions with role: <strong><em>:role</em></strong>',
        ],
        'permissions-card' => [
            'role-id'                           => 'Role Id',
            'role-name'                         => 'Role Name',
            'permissions-table-roles-caption'   => 'Roles with permission: <strong><em>:permission</em></strong>',
            'permissions-table-users-caption'   => 'Users with permission: <strong><em>:permission</em></strong>',
        ],
        'role-info-card' => [
            'role-id'           => 'Role Id',
            'role-name'         => 'Role Name',
            'role-desc'         => 'Role Description',
            'role-level'        => 'Role Level',
            'role-users'        => 'Role Users',
            'role-permissions'  => 'Role Permissions',
            'created'           => 'Created at',
            'updated'           => 'Updated at',
            'deleted'           => 'Deleted at',
            'none'              => 'None',
        ],
        'permission-info-card' => [
            'permission-id'     => 'Permission Id',
            'permission-name'   => 'Permission Name',
            'permission-slug'   => 'Permission Slug',
            'permission-model'  => 'Permission Model',
            'permission-desc'   => 'Permission Description',
            'permission-roles'  => 'Permission Roles',
            'permission-users'  => 'Permission Users',
            'created'           => 'Created at',
            'updated'           => 'Updated at',
            'deleted'           => 'Deleted at',
            'none'              => 'None',
        ],

    ],

    'roles-table' => [
        'caption'       => '{1} :count role total|[2,*] :count total roles',
        'id'            => 'ID',
        'name'          => 'Name',
        'desc'          => 'Description',
        'level'         => 'Level',
        'permissons'    => 'Permissions',
        'createdAt'     => 'Created',
        'updatedAt'     => 'Updated',
        'deletedAt'     => 'Deleted',
        'actions'       => 'Actions',
        'none'          => 'No Role Items',
    ],

    'permissions-table' => [
        'caption'       => '{1} :count permission total|[2,*] :count total permissions',
        'id'            => 'ID',
        'name'          => 'Name',
        'slug'          => 'Slug',
        'desc'          => 'Description',
        'roles'         => 'Roles',
        'createdAt'     => 'Created',
        'updatedAt'     => 'Updated',
        'deletedAt'     => 'Deleted',
        'actions'       => 'Actions',
        'none'          => 'No Permission Items',
    ],

    'buttons' => [
        'create-new-role'               => 'Create New Role',
        'show-deleted-roles'            => 'Deleted Roles',
        'show-deleted-permissions'      => 'Deleted Permissions',
        'show'                          => '<span class="hidden-xs hidden-sm">Show </span><i class="fa fa-eye fa-fw" aria-hidden="true"></i>',
        'edit'                          => '<span class="hidden-xs hidden-sm">Edit </span><i class="fa fa-pencil fa-fw" aria-hidden="true"></i>',
        'edit-larger'                   => 'Edit <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>',
        'delete'                        => '<span class="hidden-xs hidden-sm">Delete </span><i class="fa fa-trash-o fa-fw" aria-hidden="true"></i>',
        'delete-large'                  => 'Delete <i class="fa fa-trash-o fa-fw" aria-hidden="true"></i>',
        'destroy'                       => '<span class="hidden-xs hidden-sm">Destroy </span><i class="fa fa-trash fa-fw" aria-hidden="true"></i>',
        'create-new-permission'         => 'Create New Permission',
        'back-to-roles'                 => '<span class="hidden-xs">Back</span> <span class="hidden-xs hidden-sm">to Roles</span>',
        'back-to-roles-deleted'         => '<span class="hidden-xs">Back</span> <span class="hidden-xs hidden-sm">to Deleted Roles</span>',
        'back-to-permissions'           => '<span class="hidden-xs">Back</span> <span class="hidden-xs hidden-sm">to Roles Dashboard</span>',
        'back-to-permissions-deleted'   => '<span class="hidden-xs">Back</span> <span class="hidden-xs hidden-sm">to Deleted Roles Dashboard</span>',

    ],

    'tooltips' => [
        'view-user'                 => 'View User',
        'delete-role'               => 'Delete Role',
        'delete-permission'         => 'Delete Permission',
        'show-role'                 => 'Show Role',
        'show-permission'           => 'Show Permission',
        'edit-role'                 => 'Edit Role',
        'edit-permission'           => 'Edit Permission',
        'show-hide'                 => 'Show/Hide More',
        'back-roles-deleted'        => 'Back to deleted dashboard',
        'back-roles'                => 'Back to dashboard',
        'back-permissions-deleted'  => 'Back to deleted dashboard',
        'back-permissions'          => 'Back to dashboard',
        'save-role'                 => 'Save New Role',
        'update-role'               => 'Save Role Changes',
        'save-permission'           => 'Save New Permission',
        'update-permission'         => 'Save Permission Changes',
    ],

    'modals' => [
        'delete_modal_title'         => 'Delete :type :item',
        'destroy_role_title'         => 'Destroy :type :item',
        'delete_modal_message'       => 'Are you sure you want to delete :type: :item?',
        'destroy_role_message'       => 'Are you sure you want to DESTROY :item?',
        'delete_role_btn_cancel'     => 'Cancel',
        'delete_role_btn_confirm'    => 'Confirm Delete',
        'destroy_all_role_title'     => 'Destroy ALL :type :items',
        'destroy_all_role_message'   => 'Are you sure you want to DESTROY ALL Roles?',
        'btnConfirm'                 => 'Confirm',
        'btnCancel'                  => 'Cancel',
    ],

    'flash-messages' => [
        'close'                 => 'Close',
        'success'               => 'Success',
        'error'                 => 'Error',
        'whoops'                => 'Whoops! ',
        'someProblems'          => 'There were some problems with your input.',
        'successDeletedItem'    => 'Successfully Deleted :type: :item',
        'role-create'           => 'Successfully Created New Role: :role',
        'role-updated'          => 'Successfully Updated Role: :role',
        'permission-create'     => 'Successfully Created New Permission: :permission',
        'permission-updated'    => 'Successfully Updated Permission: :permission',
    ],

    'forms' => [
        'roles-form' => [
            'role-name' => [
                'label'         => 'Role Name',
                'placeholder'   => 'Type Role Name',
            ],
            'role-slug' => [
                'label'         => 'Role Slug',
                'placeholder'   => 'Type Role Slug',
            ],
            'role-desc' => [
                'label'         => 'Role Description',
                'placeholder'   => 'Type Role Description',
            ],
            'role-level' => [
                'label'         => 'Role Level',
                'placeholder'   => 'Type Role Level',
            ],
            'role-permissions' => [
                'label'         => 'Role Permissions',
                'placeholder'   => 'Select Permissions',
            ],
            'buttons' => [
                'save-role'     => [
                    'name'      => 'Save Role',
                    'sr-icon'   => 'Save Role Icon',
                ],
                'update-role'     => [
                    'name'      => 'Save Role Changes',
                    'sr-icon'   => 'Save Role Changes Icon',
                ],
            ],
        ],
        'permissions-form' => [
            'permission-name' => [
                'label'         => 'Permission Name',
                'placeholder'   => 'Type Permission Name',
            ],
            'permission-slug' => [
                'label'         => 'Permission Slug',
                'placeholder'   => 'Type Permission Slug',
            ],
            'permission-desc' => [
                'label'         => 'Permission Description',
                'placeholder'   => 'Type Permission Description',
            ],
            'permission-model' => [
                'label'         => 'Permission Model',
                'placeholder'   => 'Select Permission Model',
            ],
            'buttons' => [
                'save-permission'     => [
                    'name'      => 'Save Permission',
                    'sr-icon'   => 'Save Permission Icon',
                ],
                'update-permission'     => [
                    'name'      => 'Save Permission Changes',
                    'sr-icon'   => 'Save Permission Changes Icon',
                ],
            ],
        ],
    ],
];
