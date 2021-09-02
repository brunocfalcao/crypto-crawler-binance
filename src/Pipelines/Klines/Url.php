<?php

namespace Nidavellir\Crawler\Binance\Pipelines\Klines;

use Closure;

/**
 * Sets the simple price URL.
 *
 * Needs:
 * (mandatory) $data->coins: coin ids, comma separated.
 *
 * Adds:
 * $data->url: The URL to be called on the next pipe.
 */
class Url
{
    public function __construct()
    {
        //
    }

    public function handle($data, Closure $next)
    {
        data_set(
            $data,
            'url',
            'klines'
        );

        return $next($data);
    }
}
