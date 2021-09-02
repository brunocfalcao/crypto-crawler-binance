<?php

namespace Nidavellir\Crawler\Binance\Pipelines\Klines;

use Nidavellir\Crawler\Binance\Pipes\CanonicalCrawlingPrices;
use Nidavellir\Crawler\Binance\Pipes\CanonicalExists;
use Nidavellir\Crawler\Binance\Pipes\CrawlerStatusCheck;
use Nidavellir\Crawler\Binance\Pipes\Poll;
use Nidavellir\Crawler\Binance\Pipes\ThrottleCheck;

/**
 * Retrieves candlestick data from a specific symbol, or all of them.
 */
class Klines
{
    public function __invoke()
    {
        return [
            CanonicalExists::class,
            CanonicalCrawlingPrices::class,
            CrawlerStatusCheck::class,
            Url::class,
            Poll::class,
            ThrottleCheck::class,
            Mapper::class,
        ];
    }
}
