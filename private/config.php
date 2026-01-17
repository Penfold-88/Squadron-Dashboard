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
];
