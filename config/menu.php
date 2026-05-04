<?php
/**
 * Dynamic Menu Configuration
 * 
 * This config defines all navigation items for the sidebar.
 * Each item can be a section_label, dropdown (with children), or a link.
 */

return [
    // DASHBOARD
    [
        'type'         => 'dropdown',
        'label'        => 'Dashboard',
        'icon'         => 'fa-chart-pie',
        'key'          => 'dashboard',
        'child_keys'   => ['dashboard', 'analytics'],
        'children'     => [
            ['label' => 'Default',   'route' => '/dashboard', 'key' => 'dashboard'],
            ['label' => 'Analytics', 'route' => '/dashboard/analytics', 'key' => 'analytics'],
        ]
    ],

    // SECTION: Attendance
    [
        'type'  => 'section_label',
        'label' => 'Attendance'
    ],

    // Leave Dropdown
    [
        'type'         => 'dropdown',
        'label'        => 'Leave',
        'icon'         => 'fa-umbrella-beach',
        'key'          => 'leave',
        'child_keys'   => ['leave_overview', 'leave_records', 'leave_types', 'leave_reports', 'leave_policies'],
        'children'     => [
            ['label' => 'Leave Overview', 'route' => '/leave_management', 'key' => 'leave_overview'],
            ['label' => 'Leave Records',  'route' => '/leave-records', 'key' => 'leave_records'],
            ['label' => 'Leave Types',    'route' => '/leave-types', 'key' => 'leave_types'],
            ['label' => 'Leave Reports',  'route' => '/leave-reports', 'key' => 'leave_reports'],
            ['label' => 'Leave Policies', 'route' => '/leave-policies', 'key' => 'leave_policies'],
        ]
    ],

    // Time Off & Holidays Link
    [
        'type'  => 'link',
        'label' => 'Time Off & Holidays',
        'icon'  => 'fa-calendar',
        'route' => '/holidays',
        'key'   => 'holidays'
    ],

    // SECTION: Management
    [
        'type'  => 'section_label',
        'label' => 'management'
    ],

    // Employee Profiles Dropdown
    [
        'type'         => 'dropdown',
        'label'        => 'Employee Profiles',
        'icon'         => 'fa-users',
        'key'          => 'employees',
        'child_keys'   => ['employees_list', 'employees_detail'],
        'children'     => [
            ['label' => 'Employees List',  'route' => '/employees', 'key' => 'employees_list'],
            ['label' => 'Employee Detail', 'route' => '/employees/detail', 'key' => 'employees_detail'],
        ]
    ],

    // Departments Link
    [
        'type'  => 'link',
        'label' => 'Departments & Groups',
        'icon'  => 'fa-sitemap',
        'route' => '/departments',
        'key'   => 'departments'
    ],

    // Reports Link
    [
        'type'  => 'link',
        'label' => 'Reports',
        'icon'  => 'fa-chart-bar',
        'route' => '/reports',
        'key'   => 'reports'
    ],

    // SECTION: App
    [
        'type'  => 'section_label',
        'label' => 'App'
    ],

    // Calendar Link
    [
        'type'  => 'link',
        'label' => 'Calendar',
        'icon'  => 'fa-calendar-alt',
        'route' => '/calendar',
        'key'   => 'calendar'
    ],

    // Bulk Upload Link
    [
        'type'  => 'link',
        'label' => 'Bulk Upload',
        'icon'  => 'fa-upload',
        'route' => '/bulk-upload',
        'key'   => 'bulk_upload'
    ],

    // Events Dropdown
    [
        'type'         => 'dropdown',
        'label'        => 'Events',
        'icon'         => 'fa-calendar-day',
        'key'          => 'events',
        'child_keys'   => ['event_create', 'event_detail', 'event_list'],
        'children'     => [
            ['label' => 'Create an event', 'route' => '/events/create', 'key' => 'event_create'],
            ['label' => 'Event detail',   'route' => '/events/detail', 'key' => 'event_detail'],
            ['label' => 'Event list',     'route' => '/events', 'key' => 'event_list'],
        ]
    ],

    // E-Learning Dropdown
    [
        'type'         => 'dropdown',
        'label'        => 'E Learning',
        'icon'         => 'fa-graduation-cap',
        'key'          => 'elearning',
        'child_keys'   => ['course_list', 'course_grid', 'course_details', 'course_create', 'student_overview', 'trainer_profile'],
        'children'     => [
            ['label' => 'Course list',     'route' => '/courses', 'key' => 'course_list'],
            ['label' => 'Course grid',     'route' => '/courses/grid', 'key' => 'course_grid'],
            ['label' => 'Course details',  'route' => '/courses/details', 'key' => 'course_details'],
            ['label' => 'Create a course', 'route' => '/courses/create', 'key' => 'course_create'],
            ['label' => 'Student overview','route' => '/students', 'key' => 'student_overview'],
            ['label' => 'Trainer profile', 'route' => '/trainers', 'key' => 'trainer_profile'],
        ]
    ],

    // Support Desk Dropdown
    [
        'type'         => 'dropdown',
        'label'        => 'Support desk',
        'icon'         => 'fa-ticket-alt',
        'key'          => 'support',
        'child_keys'   => ['support_table', 'support_card', 'support_contacts', 'support_detail', 'support_tickets', 'support_links', 'support_reports'],
        'children'     => [
            ['label' => 'Table view',        'route' => '/support/table', 'key' => 'support_table'],
            ['label' => 'Card view',         'route' => '/support/card', 'key' => 'support_card'],
            ['label' => 'Contacts',          'route' => '/support/contacts', 'key' => 'support_contacts'],
            ['label' => 'Contact details',   'route' => '/support/contacts/detail', 'key' => 'support_detail'],
            ['label' => 'Tickets preview',   'route' => '/support/tickets', 'key' => 'support_tickets'],
            ['label' => 'Quick links',       'route' => '/support/quick-links', 'key' => 'support_links'],
            ['label' => 'Reports',           'route' => '/support/reports', 'key' => 'support_reports'],
        ]
    ],

    // SECTION: Profile
    [
        'type'  => 'section_label',
        'label' => 'Profile'
    ],

    // User Dropdown
    [
        'type'         => 'dropdown',
        'label'        => 'User',
        'icon'         => 'fa-user',
        'key'          => 'user',
        'child_keys'   => ['user_profile', 'user_settings'],
        'children'     => [
            ['label' => 'Profile',  'route' => '/profile', 'key' => 'user_profile'],
            ['label' => 'Settings', 'route' => '/settings', 'key' => 'user_settings'],
        ]
    ],

    // Starter Link
    [
        'type'  => 'link',
        'label' => 'Starter',
        'icon'  => 'fa-flag',
        'route' => '/starter',
        'key'   => 'starter'
    ],

    // SECTION: Documentation
    [
        'type'  => 'section_label',
        'label' => 'Documentation'
    ],

    // Getting Started Link
    [
        'type'  => 'link',
        'label' => 'Getting started',
        'icon'  => 'fa-rocket',
        'route' => '/documentation/getting-started',
        'key'   => 'getting_started'
    ],

    // Changelog Link
    [
        'type'  => 'link',
        'label' => 'Changelog',
        'icon'  => 'fa-code-branch',
        'route' => '/changelog',
        'key'   => 'changelog'
    ],
];
