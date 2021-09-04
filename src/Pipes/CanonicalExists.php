<?php

namespace Nidavellir\Crawler\Binance\Pipes;

use Closure;
use Nidavellir\CryptoCube\Models\Symbol;

/**
 * Check if the token canonical exists.
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
            $next($data) :
            throw new \Exception('Canonical does not exist');
    }
}
