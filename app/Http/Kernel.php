<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\TrustProxies::class,
        \Barryvdh\Cors\HandleCors::class,
        \App\Http\Middleware\Cors::class,
    ];


    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
            \Barryvdh\Cors\HandleCors::class,
        ],
        'admin' => [
            \App\Http\Middleware\Admin::class,
        ],
        'operationTL' => [
            \App\Http\Middleware\TeamLeaderOperation::class,
        ],
        'listingEngineer' => [
            \App\Http\Middleware\OperationListingEngineer::class,
        ],
        'salesTL' => [
            \App\Http\Middleware\salesTL::class,
        ],
        'salesDashboard' => [
            \App\Http\Middleware\SalesDashboard::class,    
        ],
        'Buyer' => [
            \App\Http\Middleware\Buyer::class
        ],
        'asst' => [
            \App\Http\Middleware\asst::class,
        ],
        'AccountExecutive' => [
            \App\Http\Middleware\AccountExecutive::class,
        ],
        'Logistics' => [
            \App\Http\Middleware\Logistics::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
         'cors'  => \Barryvdh\Cors\HandleCors::class,
    ];
}
