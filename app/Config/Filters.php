<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array<string, class-string|list<class-string>> [filter_name => classname]
     *                                                     or [filter_name => [classname1, classname2, ...]]
     */
    public array $aliases = [
    'csrf'          => CSRF::class,
    'toolbar'       => DebugToolbar::class,
    'honeypot'      => Honeypot::class,
    'invalidchars'  => InvalidChars::class,
    'secureheaders' => SecureHeaders::class,
    'filterAdmin'   => \App\Filters\FilterAdmin::class,
    'filterDivisi'  => \App\Filters\FilterDivisi::class,
    'filterPimpinan' => \App\Filters\FilterPimpinan::class,
    'filterSekretaris' => \App\Filters\FilterSekretaris::class
];

public array $globals = [
    'before' => [
        'filterAdmin' => [
            'except' => ['login/*', '/', 'search/*']
        ],
        'filterDivisi' => [
            'except' => ['login/*', '/', 'search/*']
        ],
        'filterPimpinan' => [
            'except' => ['login/*', '/', 'admin/dashboard', 'search/*']
        ],
        'filterSekretaris' => [
            'except' => ['login/*', '/', 'search/*']
        ],
    ],
    'after' => [
        'filterAdmin' => [
            'except' => ['login/*', 'admin/dashboard', 'admin/dashboard/*', 'admin/slider/*', 'admin/produk/*', 'admin/email*', 'admin/divisi*', 'admin/pimpinan*']
        ],
        'filterDivisi' => [
            'except' => ['login/*', 'admin/dashboard', 'admin/dashboard/*', 'admin/user/*', 'admin/email*', 'admin/divisi*']
        ],
        'filterPimpinan' => [
            'except' => ['login/*', 'admin/dashboard', 'admin/pimpinan/*']
        ],
        'filterSekretaris' => [
            'except' => ['login/*', 'admin/dashboard', 'admin/divisi/*', 'admin/pimpinan/*']
        ],
        'toolbar'
    ],
];

    
    

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['foo', 'bar']
     *
     * If you use this, you should disable auto-routing because auto-routing
     * permits any HTTP method to access a controller. Accessing the controller
     * with a method you don't expect could bypass the filter.
     */
    public array $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     */
    public array $filters = [];
}
