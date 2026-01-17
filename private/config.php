<?php
return [
    'db' => [
        'host' => 'localhost',
        'name' => 'squadron_dashboard',
        'user' => 'squadron_user',
        'password' => 'change_me',
    ],
    'roles' => [
        'member' => 'Verified Squadron Member',
        'editor' => 'Squadron Editor',
        'admin' => 'Squadron Admin',
        'manager' => 'Squadron Manager',
    ],
    'permissions' => [
        'gallery_upload' => ['member', 'editor', 'admin', 'manager'],
        'news_manage' => ['editor', 'manager'],
        'downloads_manage' => ['editor', 'manager'],
        'member_downloads' => ['member', 'editor', 'admin', 'manager'],
        'server_upload' => ['admin', 'manager'],
        'site_manage' => ['manager'],
    ],
    'users' => [
        [
            'username' => 'pilot',
            'password' => password_hash('flightdeck', PASSWORD_DEFAULT),
            'role' => 'member',
        ],
        [
            'username' => 'editor',
            'password' => password_hash('briefing', PASSWORD_DEFAULT),
            'role' => 'editor',
        ],
        [
            'username' => 'admin',
            'password' => password_hash('serverops', PASSWORD_DEFAULT),
            'role' => 'admin',
        ],
        [
            'username' => 'manager',
            'password' => password_hash('command', PASSWORD_DEFAULT),
            'role' => 'manager',
        ],
    ],
];
