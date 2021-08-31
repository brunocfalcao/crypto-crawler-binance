<?php

namespace Nidavellir\Crawler\Binance\Pipelines\ExchangeInformation;

use Nidavellir\Crawler\Binance\Pipes\CrawlerStatusCheck;
use Nidavellir\Crawler\Binance\Pipes\Poll;
use Nidavellir\Crawler\Binance\Pipes\ThrottleCheck;

/**
 * Retrieves a crypto currency price data line.
 */
class ExchangeInformation
{
    public function __invoke()
    {
        return [
            CrawlerStatusCheck::class,
            Url::class,
            Poll::class,
            ThrottleCheck::class,
            Mapper::class,
        ];
    }
}
