<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (Auth::check() && (! Auth::user()->is_active || ! isset(Auth::user()->email_verified_at))) {
            $isActive = Auth::user()->is_active;
            Auth::logout();
            $message = !$isActive ? 'A fiókja inaktív kérjük keresse fel az ügyfélszolgálatunkat.' : 'Kérjük erősítse meg az email címét.';
            if ($request->ajax()) {
                return response()->json(['success' => '0', 'message' => $message]);
            } else {
                return redirect()->back()->withErrors($message);
            }
        }

        return $response;
    }
}
