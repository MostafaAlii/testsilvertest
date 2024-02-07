<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';
    public const ADMIN_DASHBOARD = '/admin/dashboard';
    public const EMPLOYEE_DASHBOARD = '/employee/dashboard';
    public const COMPANY_DASHBOARD = '/company/dashboard';
    public const AGENT_DASHBOARD = '/agent/dashboard';
    public const CALL_CENTER_DASHBOARD = '/callCenter/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware(['api', 'api_secret_key_check'])->prefix('api')->group(base_path('routes/api.php'));
            Route::middleware('web')->group(base_path('routes/web.php'));
            Route::middleware('web')->group(base_path('routes/dashboard/client.php'));
            Route::middleware('web')->group(base_path('routes/dashboard/dashboard.php'));
            Route::middleware('web')->group(base_path('routes/dashboard/employee.php'));
            Route::middleware('web')->group(base_path('routes/dashboard/company.php'));
            Route::middleware('web')->group(base_path('routes/dashboard/agent.php'));
            Route::middleware('web')->group(base_path('routes/dashboard/callCenter.php'));
            Route::middleware('web')->get('/download/{filename}', function ($filename) {
                $filePath = storage_path("app/backups/{$filename}");
                if (file_exists($filePath))
                    return response()->download($filePath, $filename);
                abort(404, 'File not found');
            })->name('download');
        });
        
    }
}
