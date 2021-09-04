<?php

namespace Nidavellir\Crawler\Binance\Pipes;

use Closure;
use Nidavellir\CryptoCube\Models\Symbol;

/**
 * Check if the token canonical is crawling prices.
 *
 * Needs:
 * (mandatory) $data->canonical: canonical
 *
 * Adds:
 * nothing
 */
class CanonicalCrawlingPrices
{
    public function __construct()
    {
        //
    }

    public function handle($data, Closure $next)
    {
        return
            Symbol::firstWhere('canonical', $data->canonical)->is_crawling_prices ?
            $next($data) :
            throw new \Exception('Canonical is not crawling prices');
    }
}
