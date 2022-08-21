<?php

namespace App\Http\Middleware\JwtAuth;
use Closure;
use Illuminate\Http\Request;
use Session;

class AddAuthorizationHeader
{
    public function handle(Request $request, Closure $next)
    {
        $jwt = '';
        // ルート側で持っているmiddlewareを取得
        $current_route_middlewares = $request->route()->computedMiddleware;
        if (in_array('auth:api', $current_route_middlewares)) {
            $jwt = session('jwt');
        } else if (in_array('auth:admin', $current_route_middlewares)) {
            $jwt = session('jwt_admin');
        }
        if ($jwt) {
            // Authorizationヘッダー追加
            $request->headers->set('Authorization', 'Bearer ' . $jwt);
        }

        return $next($request);;
    }
}