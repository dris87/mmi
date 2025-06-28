<?php

declare(strict_types=1);
// 50 kulcs 8979

return [
    'dashboard' => [
        'title' => 'messages.dashboard',
        'permission_name' => 'dashboard',
        'icon' => 'fas fa fa-digital-tachograph',
        'route' => 'admin.dashboard',
        'active_pattern' => 'admin/dashboard*',
    ],
    'backoffice_users' => [
        'title' => 'messages.backoffice.user.backoffice_users',
        'permission_name' => 'backoffice_users',
        'icon' => 'fas fa-user-tie',
        'sub_menu_items' => [
            [
                'title' => 'messages.backoffice.user.backoffice_users',
                'icon' => 'fas fa-user-friends',
                'route' => 'backoffice.user.index',
                'permission_name' => 'backoffice.user.index',
                'active_pattern' => 'admin/jobs*',
            ],
            [
                'title' => 'messages.backoffice.user.backoffice_users',
                'icon' => 'fas fa-plus',
                'route' => 'backoffice.user.create',
                'permission_name' => 'backoffice.user.create',
                'active_pattern' => '/backoffice/user*',
            ],
        ],
    ],
    'jobs' => [
        'title' => 'messages.jobs',
        'permission_name' => 'jobs',
        'icon' => 'fas fa-user-tie',
        'sub_menu_items' => [
            [
                'title' => 'messages.job.heading',
                'icon' => 'fas fa-user-friends',
                'route' => 'admin.jobs.index',
                'permission_name' => 'admin.jobs.index',
                'active_pattern' => 'admin/jobs*',
            ],
            [
                'title' => 'Új hirdetés',  // Közvetlenül magyar szöveg
                'icon' => 'fas fa-plus',
                'route' => 'admin.job.create',
                'permission_name' => 'admin.job.create',
                'active_pattern' => 'admin/jobs/create',
            ],
        ],
    ],
    'companies' => [
        'title' => 'messages.employers',
        'permission_name' => 'companies',
        'icon' => 'fas fa-user-tie',
        'sub_menu_items' => [
            [
                'title' => 'messages.employers',
                'icon' => 'fas fa-user-friends',
                'route' => 'company.index',
                'permission_name' => 'company.index',
                'active_pattern' => 'admin/companies*',
            ],
            [
                'title' => 'messages.common.add',
                'icon' => 'fas fa-plus',
                'route' => 'company.create',
                'permission_name' => 'company.create',
                'active_pattern' => 'admin/companies/create',
            ],
        ],
    ],
    'candidates' => [
        'title' => 'messages.candidates',
        'permission_name' => 'candidates',
        'icon' => 'fas fa-users',
        'sub_menu_items' => [
            [
                'title' => 'messages.candidates',
                'icon' => 'fas fa-user-circle',
                'route' => 'candidates.index',
                'permission_name' => 'candidates.index',
                'active_pattern' => 'admin/candidates',
            ],
            [
                'title' => 'messages.common.add',
                'icon' => 'fas fa-plus',
                'route' => 'candidates.create',
                'permission_name' => 'candidates.create',
                'active_pattern' => 'admin/candidates/create',
            ],
        ],
    ],
    'event_log' => [
        'title' => 'messages.admin_menu.event_log',
        'permission_name' => 'event_log',
        'icon' => 'fas fa-clipboard-list',
        'route' => 'admin.event-log',
        'active_pattern' => 'admin/event-log',
    ],
    'cms' => [
        'title' => 'messages.cms',
        'permission_name' => 'cms',
        'icon' => 'fas fa-users-cog',
        'sub_menu_items' => [
            [
                'title' => 'messages.email_templates',
                'icon' => 'fas fa-envelope',
                'route' => 'email.template.index',
                'permission_name' => 'email.template.index',
                'active_pattern' => 'admin/email-template*',
            ],
            [
                'title' => 'messages.settings',
                'icon' => 'fas fa-sliders-h',
                'route' => 'settings.index',
                'permission_name' => 'settings.index',
                'active_pattern' => 'admin/settings*',
            ],
        ],
    ],
];
