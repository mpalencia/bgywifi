<?php namespace BrngyWiFi\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{

    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
        'Illuminate\Cookie\Middleware\EncryptCookies',
        'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
        'Illuminate\Session\Middleware\StartSession',
        'Illuminate\View\Middleware\ShareErrorsFromSession',
        //'BrngyWiFi\Http\Middleware\VerifyCsrfToken',
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => 'BrngyWiFi\Http\Middleware\Authenticate',
        'auth.basic' => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
        'guest' => 'BrngyWiFi\Http\Middleware\RedirectIfAuthenticated',
        'authrole' => 'BrngyWiFi\Http\Middleware\RedirectBaseOnRole',
        'jwt.auth' => \Tymon\JWTAuth\Middleware\GetUserFromToken::class,
        'jwt.refresh' => \Tymon\JWTAuth\Middleware\RefreshToken::class,
        'jwt.validate' => \BrngyWiFi\Http\Middleware\ValidateToken::class,
        'cors' => 'Barryvdh\Cors\HandleCors',
        'APIJWT.auth' => \BrngyWiFi\Http\Middleware\APIJWTAuth::class,
        'validate_token' => \BrngyWiFi\Http\Middleware\ValidateToken::class,
    ];

}
