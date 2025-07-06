<?php

return [
    
    /*
    |--------------------------------------------------------------------------
    | Performance Settings
    |--------------------------------------------------------------------------
    |
    | Performance-related configuration for the application
    |
    */
    
    'pagination' => [
        'default_per_page' => 15,
        'max_per_page' => 100,
    ],
    
    'cache' => [
        'dashboard_stats_ttl' => 15, // minutes
        'user_stats_ttl' => 30, // minutes
        'recent_tasks_ttl' => 10, // minutes
    ],
    
    'database' => [
        'chunk_size' => 1000,
        'max_export_records' => 10000,
    ],
    
    'search' => [
        'enable_full_text' => env('ENABLE_FULL_TEXT_SEARCH', true),
        'min_search_length' => 3,
    ],
    
    'session' => [
        'track_activity_interval' => 300, // 5 minutes
    ],
    
];
