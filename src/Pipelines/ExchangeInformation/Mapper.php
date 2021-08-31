<?php

namespace Nidavellir\Crawler\Binance\Pipelines\ExchangeInformation;

use Closure;

/**
 * Maps the respective symbols data into the database (creates or updates).
 *
 * Needs:
 * (mandatory) $data->response: Illuminate\Http\Client\Response (array)
 *
 * Adds:
 * $data->symbols: The returned symbols, now as model instances, from the
 *                 response
 */
class Mapper
{
    public function __construct()
    {
        //
    }

    public function handle($data, Closure $next)
    {
        dd('here', $data->response->json());

        return $next($data);
    }
}
