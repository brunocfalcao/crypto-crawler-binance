<?php

namespace Nidavellir\Crawler\Binance\Pipes;

use Closure;
use Illuminate\Support\Facades\Http;
use Nidavellir\Crawler\Binance\BinanceCrawler;

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
        $data->method = $this->parameters ? 'post' : 'get';

        $http = new Http();

        $data->headers = array_merge(
            $data->headers ?? [],
            BinanceCrawler::headers()
        );

        $prefix = 'https://api'.rand(1, 3).'.binance.com/api/v3/';
        $response = $http::withHeaders($data->headers)
                         ->withOptions(BinanceCrawler::options())
                         ->{strtolower($method)}(
                             $prefix.$data->url,
                             $data->parameters ?? []
                         );

        data_set($data, 'response', $response);

        return $next($data);
    }
}
