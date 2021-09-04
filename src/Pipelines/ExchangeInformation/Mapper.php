<?php

namespace Nidavellir\Crawler\Binance\Pipelines\ExchangeInformation;

use Closure;
use Nidavellir\CryptoCube\Models\Token;

/**
 * Maps the respective tokens data into the database (creates or updates).
 *
 * Needs:
 * (mandatory) $data->response: Illuminate\Http\Client\Response (array)
 *
 * Adds:
 * $data->tokens: The returned tokens, now as model instances, from the
 *                 response
 */
class Mapper
{
    public function __construct()
    {
        //
    }

    public function handle($data, Closure $next)
    {
        $tokens = $data->response->json()['symbols'];

        foreach ($tokens as $token) {
            $token = (object) $token;

            if (! Token::firstWhere('canonical', $token->symbol)) {
                $model = new Token();
                $model->canonical = strtoupper($token->symbol);
                $model->base_asset = $token->baseAsset;
                $model->quote_asset = $token->quoteAsset;
                $model->save();
            }
        }

        return $next($data);
    }
}
