<?php

namespace Nidavellir\Crawler\Binance\Pipes;

use Closure;
use Illuminate\Support\Facades\Http;

/**
 * Fetches an URL.
 *
 * Needs:
 * (mandatory) $data->url: The url that should will be polled (string)
 * (optional)  $data->method: GET or POST (string) (default='get')
 * (optional)  $data->headers: Additional headers (array assoc.)
 * (optional)  $data->parameters: Additional querystring parameters (array assoc.)
 *
 * Adds:
 * $data->response: Illuminate\Http\Client\Response
 * https://laravel.com/docs/8.x/http-client#making-requests
 */
class Poll
{
    public function __construct()
    {
        //
    }

    public function handle($data, Closure $next)
    {
        $method = $data->method ?? 'get';
        $http = new Http();

        if (isset($data->headers)) {
            $http::withHeaders($data->headers);
        }

        $querystring = '';

        if (isset($data->parameters)) {
            foreach ($data->parameters as $key => $value) {
                $querystring .= "{$key}=".urlencode($value).'&';
            }
        }

        // Remove last &.
        if (! empty($querystring)) {
            $querystring = '?'.substr($querystring, 0, -1);
        }

        $prefix = 'https://api'.rand(1, 3).'.binance.com/api/v3/';
        $response = $http::{strtolower($method)}($prefix.$data->url.$querystring);

        data_set($data, 'response', $response);

        return $next($data);
    }
}
