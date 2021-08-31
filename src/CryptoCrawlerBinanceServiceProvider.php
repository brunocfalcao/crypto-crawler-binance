<?php

namespace Nidavellir\Crawler\Binance;

use Illuminate\Support\ServiceProvider;

final class CryptoCrawlerBinanceServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('crypto.crawler', BinanceCrawler::class);
    }

    public function boot()
    {
        //
    }
}
