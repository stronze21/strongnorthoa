<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Report Types
    |--------------------------------------------------------------------------
    |
    | This file contains configuration options for the reporting system.
    |
    */

    'types' => [
        'shows' => [
            'name' => 'Cooking Shows',
            'description' => 'Reports about cooking shows, including bookings, results, and performance.',
            'model' => \App\Models\CookingShow::class,
            'export' => \App\Exports\ShowsExport::class,
        ],
        'lifechangers' => [
            'name' => 'Lifechangers',
            'description' => 'Reports about lifechangers, their status, and performance.',
            'model' => \App\Models\User::class,
            'export' => \App\Exports\LifechangersExport::class,
        ],
        'orders' => [
            'name' => 'Orders',
            'description' => 'Reports about orders, sales, and payments.',
            'model' => \App\Models\Order::class,
            'export' => \App\Exports\OrdersExport::class,
        ],
        'contests' => [
            'name' => 'Contests',
            'description' => 'Reports about contests and performance metrics.',
            'model' => \App\Models\Contest::class,
            'export' => \App\Exports\ContestPerformanceExport::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Export Formats
    |--------------------------------------------------------------------------
    |
    | Available export formats for reports.
    |
    */

    'formats' => [
        'excel' => [
            'name' => 'Excel',
            'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'extension' => 'xlsx',
            'type' => \Maatwebsite\Excel\Excel::XLSX,
        ],
        'csv' => [
            'name' => 'CSV',
            'mime' => 'text/csv',
            'extension' => 'csv',
            'type' => \Maatwebsite\Excel\Excel::CSV,
        ],
        'pdf' => [
            'name' => 'PDF',
            'mime' => 'application/pdf',
            'extension' => 'pdf',
            'type' => \Maatwebsite\Excel\Excel::DOMPDF,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Report Permissions
    |--------------------------------------------------------------------------
    |
    | Define which user roles can access which reports.
    |
    */

    'permissions' => [
        'shows' => ['admin', 'manager', 'user'],
        'lifechangers' => ['admin', 'manager'],
        'orders' => ['admin', 'manager', 'user'],
        'contests' => ['admin', 'manager'],
        'dashboard' => ['admin', 'manager'],
        'custom' => ['admin', 'manager'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Chart Colors
    |--------------------------------------------------------------------------
    |
    | Colors used in report charts.
    |
    */

    'chart_colors' => [
        'primary' => '#4F81BD',
        'secondary' => '#C0504D',
        'tertiary' => '#9BBB59',
        'quaternary' => '#8064A2',
        'booked' => '#4F81BD',
        'closed' => '#9BBB59',
        'cancelled' => '#C0504D',
        'orders' => '#4BACC6',
        'sales' => '#F79646',
    ],
];