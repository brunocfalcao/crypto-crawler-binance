<?php

namespace Nidavellir\Crawler\Binance\Pipelines\ExchangeInformation;

use Closure;
use Nidavellir\CryptoCube\Models\Symbol;

/**
 * Check if the symbol canonical exists.
 *
 * Needs:
 * (mandatory) $data->canonical: canonical
 *
 * Adds:
 * nothing
 */
class CanonicalExists
{
    public function __construct()
    {
        //
    }

    public function handle($data, Closure $next)
    {
        return
            Symbol::firstWhere('canonical', $data->canonical) ?
            false :
            $next($data);
    }
}
