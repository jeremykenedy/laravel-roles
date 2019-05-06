<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel Roles Language Lines - laravelblocker
    |--------------------------------------------------------------------------
    */

    'titles' => [
        'dashboard'         => 'Roles Dashboard',
        'show-role'         => 'Showing Role: <strong>:name</strong>',
        'roles-table'       => 'Active Roles',
        'roles-card'        => 'Roles',
        'role-card'         => 'Role: ',
        'permissions-card'  => 'Permissions',
        'permissions-table' => 'Active Permissions',
    ],

    'cards' => [
        'users-count'         => '{1} :count user|[2,*] :count users',
        'permissions-count'   => '{1} :count permission|[2,*] :count permissions',
        'roles-count'         => '{1} :count role|[2,*] :count roles',
        'none-count'          => 'None',
        'role-card'           => [
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
            'role-permissons'   => 'Role Permissions',
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

    'buttons' => [
        'create-new-role'       => 'Create New Role',
        'show-deleted-roles'    => 'Deleted Roles',
        'show'                  => '<span class="hidden-xs hidden-sm">Show </span><i class="fa fa-eye fa-fw" aria-hidden="true"></i>',
        'edit'                  => '<span class="hidden-xs hidden-sm">Edit </span><i class="fa fa-pencil fa-fw" aria-hidden="true"></i>',
        'edit-larger'           => 'Edit <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>',
        'delete'                => '<span class="hidden-xs hidden-sm">Delete </span><i class="fa fa-trash-o fa-fw" aria-hidden="true"></i>',
        'delete-large'          => 'Delete <i class="fa fa-trash-o fa-fw" aria-hidden="true"></i>',
        'destroy'               => '<span class="hidden-xs hidden-sm">Destroy </span><i class="fa fa-trash fa-fw" aria-hidden="true"></i>',
        'create-new-permission' => 'Create New Permission',
        'back-to-roles'         => '<span class="hidden-xs">Back</span> <span class="hidden-xs hidden-sm">to Roles</span>',
        'back-to-roles-deleted' => '<span class="hidden-xs">Back</span> <span class="hidden-xs hidden-sm">to Deleted Roles</span>',
    ],

    'tooltips' => [
        'view-user'             => 'View User',
        'delete-role'           => 'Delete Role',
        'show-role'             => 'Show Role',
        'edit-role'             => 'Edit Role',
        'show-hide'             => 'Show/Hide More',
        'back-roles-deleted'    => 'Back to deleted roles',
        'back-roles'            => 'Back to roles',
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
        'successDeletedItem'    => 'Successfully Releted :type: :role',
    ],
];
