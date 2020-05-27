<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $contact = $request->route('contact');

        if($contact->user_id == Auth::id())
        {
            return $next($request);
        }
        return redirect(route('contacts.index'))->with('status', 'Access denied!');
    }
}
