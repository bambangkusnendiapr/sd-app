<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => true,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'developer' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u'
        ],
        'admin' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u'
        ],
        'wali_kelas' => [
            'profile' => 'r,u'
        ],
        'guru' => [
            'profile' => 'r,u',
        ],
        'wali_siswa' => [
            'profile' => 'r,u'
        ],
        'siswa' => [
            'profile' => 'r,u'
        ]
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
