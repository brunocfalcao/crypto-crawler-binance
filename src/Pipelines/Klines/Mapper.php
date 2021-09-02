<?php

namespace Nidavellir\Crawler\Binance\Pipelines\Klines;

use Closure;
use Nidavellir\CryptoCube\Models\Candlestick;
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
        /**
         * Klines added to the symbol.
         * Only add the line in case the timestamp doesn't exist.
         */
        $klines = $data->response->json();

        foreach ($klines as $line) {
            $symbol = Symbol::firstWhere('canonical', $data->canonical);

            // Only save if the canonical milisecond candlestick doesn't exist.
            if (! Candlestick::where('symbol_id', $symbol->id)
                            ->where('opened_at_milliseconds', $line[0])->first()) {
                $candlestick = new Candlestick();
                $candlestick->symbol_id = $symbol->id;
                $candlestick->opened_at_milliseconds = $line[0];
                $candlestick->opened_at = milliseconds($line[0]);
                $candlestick->open = round($line[1], 4);
                $candlestick->high = round($line[2], 4);
                $candlestick->low = round($line[3], 4);
                $candlestick->close = round($line[4], 4);
                $candlestick->volume = round($line[5], 4);
                $candlestick->closed_at_milliseconds = $line[6];
                $candlestick->closed_at = milliseconds($line[6]);
                $candlestick->quote_asset_volume = round($line[7], 4);
                $candlestick->trades = $line[8];
                $candlestick->taker_buy_base_asset_volume = round($line[9], 4);
                $candlestick->taker_buy_quote_asset_volume = round($line[9], 4);
                $candlestick->save();
            }
        }

        return $next($data);
    }
}
