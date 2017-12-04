<?php

use App\Coin;
use App\Price;
use Unirest\Request;

Route::get('/init', function () {
    $response = Request::get('https://api.coinmarketcap.com/v1/ticker/?limit=200');

    $coins = json_decode(json_encode($response->body));

    foreach ($coins as $coin) {
        $coin = (array) json_decode(json_encode($coin));

        $name = (string) $coin['name'];
        $symbol = (string) $coin['id'];

        $priceUsd = $coin['price_usd'];
        $priceBtc = $coin['price_btc'];
        $volume = (float) $coin['24h_volume_usd'];
        $supply = $coin['available_supply'];
        $marketCap = $coin['market_cap_usd'];
        $percentChangeVolume = 0;
        $percentChangeBtc = 0;
        $percentChangeUsd = 0;
        $btcPerSecond = 0;
        $usdPerSecond = 0;

        $coin = Coin::create(['name' => $name, 'symbol' => $symbol]);

        Price::create(
            [
                'coin_id' => $coin->id,
                'price_btc' => $priceBtc,
                'price_usd' => $priceUsd,
                'volume' => $volume,
                'supply' => $supply,
                'market_cap' => $marketCap,
                'percent_volume' => $percentChangeVolume,
                'percent_btc' => $percentChangeBtc,
                'percent_usd' => $percentChangeUsd,
                'btc_s' => $btcPerSecond,
                'usd_s' => $usdPerSecond,
            ]
        );
    }

    return redirect('/');
});

Route::get('/', 'CoinsController@index');
Route::get('/update', 'CoinsController@update');
Route::get('/{symbol}', 'CoinsController@show');
