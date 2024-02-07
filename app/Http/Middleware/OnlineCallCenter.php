<?php

namespace App\Http\Middleware;
use Closure;
use App\Models\Callcenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
class OnlineCallCenter {
    public function handle(Request $request, Closure $next) {
        if(auth('call-center')->check()) {
            $expireAt = now()->addMinutes(2);
            Cache::put('callcenter-online', auth('call-center')->user()->id, true, $expireAt);
            Callcenter::whereId(auth('call-center')->user()->id)->update([
                'last_seen' => now()
            ]);
        }
        return $next($request);
    }
}