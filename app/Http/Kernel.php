<?php

namespace App\Http;

use App\Http\Middleware\App;
use App\Http\Middleware\EncryptCookies;
use App\Http\Middleware\EnrolledCourse;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

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
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            App::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
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
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'tenancy.enforce' => \App\Http\Middleware\EnforceTenancy::class,
        'admin'=> \App\Http\Middleware\Admin::class,
        'member'=> \App\Http\Middleware\Member::class,
        'department'=> \App\Http\Middleware\Department::class,
        'sms'=> \App\Http\Middleware\AdminSms::class,
        'department.admin'=> \App\Http\Middleware\DepartmentAdmin::class,
        'setup'=> \App\Http\Middleware\Setup::class,
        'subscriber'=> \App\Http\Middleware\Subscriber::class,
        'cart'=> \App\Http\Middleware\InvoicePresent::class,
        'billingAddress'=>\App\Http\Middleware\BillingAddressPresent::class,
        'storage'=>\App\Http\Middleware\Storage::class,
        'currency'=>\App\Http\Middleware\SetCurrency::class,
        'user-limit'=>\App\Http\Middleware\UserLimit::class,
        'api.auth'=>\App\Http\Middleware\ApiAuth::class,
        'api.admin'=>\App\Http\Middleware\ApiAdmin::class,
        'api.department'=>\App\Http\Middleware\ApiDepartment::class,
        'api.department-admin'=>\App\Http\Middleware\ApiDepartmentAdmin::class,
        'enrolled-course'=>EnrolledCourse::class,
    ];

    /**
     * The priority-sorted list of middleware.
     *
     * This forces non-global middleware to always be in the given order.
     *
     * @var array
     */
    protected $middlewarePriority = [
        StartSession::class,
        ShareErrorsFromSession::class,
        \App\Http\Middleware\Authenticate::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
    ];
}
