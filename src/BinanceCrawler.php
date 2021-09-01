<?php

namespace Nidavellir\Crawler\Binance;

use Illuminate\Support\Facades\Http;

class BinanceCrawler
{
    public static function __callStatic($method, $args)
    {
        return BinanceCrawlerService::new()->{$method}(...$args);
    }
}

class BinanceCrawlerService
{
    protected $data = [];
    protected $pipeline = null;
    protected $response = null;
    protected $error = null;

    public function __construct()
    {
        //
    }

    public static function new(...$args)
    {
        return new self(...$args);
    }

    /**
     * Sets a data path attribute in the $this->data attribute.
     * Uses the data_set() helper, so you can make like
     * $this->set('name.surname', 'Falcao');.
     *
     * @param string $path
     * @param mixed $value
     */
    public function set(string $path, $value)
    {
        data_set($this->data, $path, $value);

        return $this;
    }

    /**
     * Sets the crawline pipeline that should be used to crawl data.
     *
     * @param  string $class Pipeline class
     *
     * @return \Nidavellir\CryptoCrawler\CryptoCrawlerService
     */
    public function onPipeline(string $pipeline)
    {
        $this->pipeline = $pipeline;

        return $this;
    }

    public function crawl()
    {
        app(\Illuminate\Pipeline\Pipeline::class)
            ->send($this->data())
            ->through((new $this->pipeline())())
            ->thenReturn();
    }

    /**
     * Returns the data token to be used in the pipeline.
     *
     * @return stdClass
     */
    private function data()
    {
        return (object) $this->data;
    }
}
