<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GetImage 
{
    public function handle(Request $request, Closure $next)
    {
		$url = substr($request->url(), strpos($request->url(), "/", 7));
		if (Str::startsWith($url, ["/img/u/", "/img/r/"])) {
			error_log(substr($url, 7));
            $path = hash('sha256', substr($url, 7));
			if (Storage::disk('local')->exists('public/'.$path.'.png')) {
				return Storage::response(headers: ["Content-Type: image/png"], path:  'public/'.$path.'.png', name: substr($url, 7));
			} 
			return response(404);
		}
        return $next($request);
    }
}
