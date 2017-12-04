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

Route::get('/update', function () {
    $response = Request::get('https://api.coinmarketcap.com/v1/ticker/?limit=200');

    $data = json_decode(json_encode($response->body));

    foreach ($data as $coin) {
        $coin = (array) json_decode(json_encode($coin));

        $symbol = (string) $coin['id'];

        $priceUsd = (float) $coin['price_usd'];
        $priceBtc = (float) $coin['price_btc'];
        $volume = (float) $coin['24h_volume_usd'];
        $supply = $coin['available_supply'];
        $marketCap = $coin['market_cap_usd'];
        // $percentChangeVolume = (float) 0;
        // $percentChangeBtc = (float) 0;
        // $percentChangeUsd = (float) 0;

        $databaseCoin = Coin::where('symbol', '=', $symbol)->first();

        // $firstPriceOfToday = $databaseCoin->firstPriceOfToday();

        // echo ($coin->startOfDay($startOfDay)['volume']);

        // $wantedCoin = $coin->firstPrice()->where('created_at', '>', $startOfDay)->get()->last()->price_usd;

        $lastVolume = $databaseCoin->firstPriceOfToday()->volume;
        $lastBtcPrice = $databaseCoin->firstPriceOfToday()->price_btc;
        $lastUsdPrice = $databaseCoin->firstPriceOfToday()->price_usd;

        $percentChangeVolume = getPercentChange($lastVolume, $volume);
        $percentChangeBtc = getPercentChange($lastBtcPrice, $priceBtc);
        $percentChangeUsd = getPercentChange($lastUsdPrice, $priceUsd);

        // $previousBtcPrice = (float) $datadatabaseCoin->prices()->latest()->first()->priceBtc;
        $previousBtcPrice = (float) $databaseCoin->firstPriceOfToday()->price_btc;
        // dd($previousBtcPrice);
        $previousUsdPrice = (float) $databaseCoin->firstPriceOfToday()->price_usd;

        $duration = Carbon::now()->diffInSeconds($databaseCoin->firstPriceOfToday()->created_at);

        $btcPerSecond = ($priceBtc - $previousBtcPrice) / $duration;
        $usdPerSecond = ($priceUsd - $previousUsdPrice) / $duration;

        // dd($previousUsdPrice, $priceUsd, $usdPerSecond);

        $price = Price::create(
            [
                'coin_id' => $databaseCoin->id,
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
});

function getPercentChange($oldNumber, $newNumber)
{
    if ($oldNumber == 0) {
        return (float) 0;
    } else {
        $changeValue = $newNumber - $oldNumber;

        return (float) ($changeValue / $oldNumber) * 100;
    }
}

Route::get('/', 'CoinsController@index');
Route::get('/update', 'CoinsController@update');
Route::get('/{symbol}', 'CoinsController@show');
