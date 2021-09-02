<?php

namespace Nidavellir\Crawler\Binance;

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

    public function __construct()
    {
        //
    }

    public static function new(...$args)
    {
        return new self(...$args);
    }

    /**
     * Gets data from the data attribute using the path.
     *
     * @param string $path
     *
     * @return $mixed
     */
    public function get(string $path)
    {
        return data_get($this->data, $path);

        return $this;
    }

    /**
     * Sets a data path attribute in the $this->data attribute.
     * Uses the data_set() helper, so you can make like
     * $this->set('name.surname', 'Falcao');.
     *
     * @param string $path
     * @param mixed $value
     *
     * @return \Nidavellir\CryptoCrawler\CryptoCrawlerService
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
     * Returns the default CURL headers for this crawler.
     * If not headers are to be sent, should return an empty array.
     *
     * @return array
     */
    public function headers()
    {
        return ['X-MBX-APIKEY' => env('CRYPTO_CRAWLER_API')];
    }

    /**
     * Returns the default CURL options for this crawler.
     * If not headers are to be sent, should return an empty array.
     *
     * @return array
     */
    public function options()
    {
        return [CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_ENCODING => '', ];
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
