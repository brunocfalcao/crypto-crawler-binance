<?php

namespace Nidavellir\Crawler\Binance\Pipes;

use Closure;

/**
 * Verifies the response from binance to see if we can make a next
 * request or make a cool down for a period of time.
 *
 * Needs:
 * (mandatory) $data->response
 *
 * Adds:
 * nothing
 */
class ThrottleCheck
{
    public function __construct()
    {
        //
    }

    public function handle($data, Closure $next)
    {
        if ($data->response->failed()) {
            $error = $data->response->json();

            // Controller error? Show message.
            if (array_key_exists('msg', $error)) {
                throw new \Exception($error['msg']);
            }

            // Cool down crawler.
            if (response->header('Retry-After') !== null) {
                $retryAfter = now()->addSeconds($response->header('Retry-After'));
            }

            return;
        }

        return $next($data);
    }
}
