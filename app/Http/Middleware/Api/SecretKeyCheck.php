<?php
namespace App\Http\Middleware\Api;
use Closure;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\Http\Traits\Api\ApiResponseTrait;
use Symfony\Component\HttpFoundation\Response;
class SecretKeyCheck {
    use ApiResponseTrait;
    public function handle(Request $request, Closure $next): Response {
        $providedApiSecretKey = $request->input('api_secret_key');
        $setting = Settings::where('api_secret_key', $providedApiSecretKey)->first();
        if (!$providedApiSecretKey) 
            return $this->errorResponse('Secret Key is required.', 401);
        if (!$setting)
            return $this->errorResponse('Secret Key is invalid.', 401);
        
        return $next($request);
    }
}