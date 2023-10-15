<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserLastActiveAt
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if ($user instanceof User) {
            if (!is_null($user)) {
                $user->forceFill([
                    'last_active_at' => Carbon::now(),
                ])->save();
            }
        }
        return $next($request);
    }
}
