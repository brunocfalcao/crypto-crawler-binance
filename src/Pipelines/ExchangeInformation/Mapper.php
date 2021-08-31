<?php

namespace Nidavellir\Crawler\Binance\Pipelines\ExchangeInformation;

use Closure;
use Nidavellir\CryptoCube\Models\Symbol;

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
        $symbols = $data->response->json()['symbols'];

        foreach ($symbols as $symbol) {
            $symbol = (object) $symbol;

            if (! Symbol::firstWhere('canonical', $symbol->symbol)) {
                $model = new Symbol();
                $model->canonical = strtoupper($symbol->symbol);
                $model->base_asset = $symbol->baseAsset;
                $model->quote_asset = $symbol->quoteAsset;
                $model->save();
            }
        }

        return $next($data);
    }
}
