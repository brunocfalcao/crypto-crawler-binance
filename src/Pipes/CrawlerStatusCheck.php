<?php

namespace Nidavellir\Crawler\Binance\Pipes;

use Closure;
use Nidavellir\CryptoCube\Models\Crawler;

/**
 * Verifies if this Binance Crawler can be used.
 *
 * Needs:
 * nothing.
 *
 * Adds:
 * nothing.
 */
class CrawlerStatusCheck
{
    public function __construct()
    {
        //
    }

    public function handle($data, Closure $next)
    {
        $crawler = Crawler::firstWhere('acronym', 'binance');

        // Crawler exists?
        if (! $crawler) {
            throw new \Exception('Crawler binance not loaded!');
            return false;
        }

        // Crawler is live?
        if (! $crawler->is_live) {
            throw new \Exception('Crawler ' . $crawler . ' is not live!');
            return false;
        }

        // Cool down exists and it's in the future?
        if ($crawler->cooldown_until != null && $crawler->cooldown_until->greaterThan(now())) {
            return false;
        }

        return $next($data);
    }
}
