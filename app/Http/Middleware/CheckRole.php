<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Если у пользователя есть хотя бы одна из требуемых ролей (или он суперадмин)
        foreach ($roles as $role) {
            if ($user->hasRole($role) || $user->hasRole('admin')) {
                return $next($request);
            }
        }

        // Если это обычный пользователь, отправляем на его страницу
        if ($user->hasRole('user')) {
            return redirect()->route('user.dashboard');
        }

        abort(403, 'Доступ запрещен. У вас недостаточно прав.');
    }
}