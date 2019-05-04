<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel Roles Language Lines - laravelblocker
    |--------------------------------------------------------------------------
    */

    'titles' => [
        'roles-table'       => 'Available Roles',
        'roles-card'        => 'Roles',
        'role-card'         => 'Role: ',
        'permissions-card'  => 'Permissions',
    ],

    'cards' => [
        'users-count'   => '{1} :count user|[2,*] :count users',
        'permissions-count'   => '{1} :count permission|[2,*] :count permissions',
        'roles-count'   => '{1} :count role|[2,*] :count roles',
        'none-count'    => 'None',
        'role-card' => [
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
    ],

    'roles-table' => [
        'caption'   => '{1} :count role total|[2,*] :count total roles',
        'id'        => 'ID',
        'name'      => 'Name',
        'desc'      => 'Description',
        'level'     => 'Level',
        'createdAt' => 'Created',
        'updatedAt' => 'Updated',
        'deletedAt' => 'Deleted',
        'actions'   => 'Actions',
        'none'      => 'No Role Items',
    ],

    'buttons' => [
        'create-new-role'       => 'Create New Role',
        'show-deleted-roles'    => 'Deleted Roles',
    ],

    'tooltips' => [
        'view-user' => 'View User',
    ]

];
