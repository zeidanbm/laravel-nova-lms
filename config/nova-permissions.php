<?php

return [
    /*
    |--------------------------------------------------------------------------
    | User model class
    |--------------------------------------------------------------------------
    */

    'user_model' => 'App\Models\User',

    /*
    |--------------------------------------------------------------------------
    | Nova User resource tool class
    |--------------------------------------------------------------------------
    */

    'user_resource' => 'App\Nova\User',

    /*
    |--------------------------------------------------------------------------
    | The group associated with the resource
    |--------------------------------------------------------------------------
    */

    'role_resource_group' => 'Administration',

    /*
    |--------------------------------------------------------------------------
    | Database table names
    |--------------------------------------------------------------------------
    | When using the "HasRoles" trait from this package, we need to know which
    | table should be used to retrieve your roles. We have chosen a basic
    | default value but you may easily change it to any table you like.
    */

    'table_names' => [
        'roles' => 'roles',

        'role_permission' => 'role_permission',

        'role_user' => 'role_user',
        
        'users' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Application Permissions
    |--------------------------------------------------------------------------
    */

    'permissions' => [
        'view users' => [
            'display_name' => 'View users',
            'description'  => 'Can view users',
            'group'        => 'User',
        ],

        'create users' => [
            'display_name' => 'Create users',
            'description'  => 'Can create users',
            'group'        => 'User',
        ],

        'edit users' => [
            'display_name' => 'Edit users',
            'description'  => 'Can edit users',
            'group'        => 'User',
        ],
        
        'edit own users' => [
            'display_name' => 'Edit own users',
            'description'  => 'Can edit own users',
            'group'        => 'User',
        ],

        'delete users' => [
            'display_name' => 'Delete users',
            'description'  => 'Can delete users',
            'group'        => 'User',
        ],

        'view roles' => [
            'display_name' => 'View roles',
            'description'  => 'Can view roles',
            'group'        => 'Role',
        ],

        'create roles' => [
            'display_name' => 'Create roles',
            'description'  => 'Can create roles',
            'group'        => 'Role',
        ],

        'edit roles' => [
            'display_name' => 'Edit roles',
            'description'  => 'Can edit roles',
            'group'        => 'Role',
        ],

        'delete roles' => [
            'display_name' => 'Delete roles',
            'description'  => 'Can delete roles',
            'group'        => 'Role',
        ],
        
        'view catalogs' => [
            'display_name' => 'View catalogs',
            'description'  => 'Can view catalogs',
            'group'        => 'Catalog',
        ],
        
        'view own catalogs' => [
            'display_name' => 'View own catalogs',
            'description'  => 'Can view owned catalogs',
            'group'        => 'Catalog',
        ],

        'create catalogs' => [
            'display_name' => 'Create catalogs',
            'description'  => 'Can create catalogs',
            'group'        => 'Catalog',
        ],

        'edit catalogs' => [
            'display_name' => 'Edit catalogs',
            'description'  => 'Can edit catalogs',
            'group'        => 'Catalog',
        ],
        
        'edit own catalogs' => [
            'display_name' => 'Edit own catalogs',
            'description'  => 'Can edit own catalogs',
            'group'        => 'Catalog',
        ],

        'delete catalogs' => [
            'display_name' => 'Delete catalogs',
            'description'  => 'Can delete catalogs',
            'group'        => 'Catalog',
        ],
        
        'view tags' => [
            'display_name' => 'View tags',
            'description'  => 'Can view tags',
            'group'        => 'Tag',
        ],

        'create tags' => [
            'display_name' => 'Create tags',
            'description'  => 'Can create tags',
            'group'        => 'Tag',
        ],

        'edit tags' => [
            'display_name' => 'Edit tags',
            'description'  => 'Can edit tags',
            'group'        => 'Tag',
        ],

        'delete tags' => [
            'display_name' => 'Delete tags',
            'description'  => 'Can delete tags',
            'group'        => 'Tag',
        ],
        
        'view topics/subtopics' => [
            'display_name' => 'View topics/subtopics',
            'description'  => 'Can view topics/subtopics',
            'group'        => 'SubTopic',
        ],

        'create topics/subtopics' => [
            'display_name' => 'Create topics/subtopics',
            'description'  => 'Can create topics/subtopics',
            'group'        => 'SubTopic',
        ],

        'edit topics/subtopics' => [
            'display_name' => 'Edit topics/subtopics',
            'description'  => 'Can edit topics/subtopics',
            'group'        => 'SubTopic',
        ],

        'delete topics/subtopics' => [
            'display_name' => 'Delete topics/subtopics',
            'description'  => 'Can delete topics/subtopics',
            'group'        => 'SubTopic',
        ],
    ],
    
    'admin_permissions' => [
        'view users',
        'create users',
        'edit users',
        'delete users',
        'view roles',
        'create roles',
        'edit roles',
        'delete roles',
        'view catalogs',
        'create catalogs',
        'edit catalogs',
        'delete catalogs',
        'view tags',
        'create tags',
        'edit tags',
        'delete tags',
        'view topics/subtopics',
        'create topics/subtopics',
        'edit topics/subtopics',
        'delete topics/subtopics'
    ],
    
    'editor_permissions' => [
        'edit own users',
        'view catalogs',
        'view own catalogs',
        'create catalogs',
        'edit catalogs',
        'delete catalogs',
        'view tags',
        'create tags',
        'edit tags',
        'delete tags',
        'view topics/subtopics',
        'create topics/subtopics',
        'edit topics/subtopics',
        'delete topics/subtopics'
    ],
    
    'writer_permissions' => [
        'edit own users',
        'view own catalogs',
        'edit own catalogs',
        'create catalogs',
        'edit catalogs',
        'view tags',
        'view topics/subtopics'
    ]
];
