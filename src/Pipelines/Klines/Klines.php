<?php

namespace Nidavellir\Crawler\Binance\Pipelines\ExchangeInformation;

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
            CrawlerStatusCheck::class,
            Url::class,
            Poll::class,
            ThrottleCheck::class,
            Mapper::class,
        ];
    }
}
