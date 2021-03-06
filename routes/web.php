<?php

use App\Coin;
use App\Price;
use Carbon\Carbon;
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
        $percentChangeMarket = 0;
        $percentChangeVolume = 0;
        $percentChangeBtc = 0;
        $percentChangeUsd = 0;
        $btcPerSecond = 0;
        $usdPerSecond = 0;
        $speed = 0;

        $coin = Coin::create(['name' => $name, 'symbol' => $symbol]);

        Price::create(
            [
                'coin_id' => $coin->id,
                'price_btc' => $priceBtc,
                'price_usd' => $priceUsd,
                'volume' => $volume,
                'supply' => $supply,
                'market_cap' => $marketCap,
                'percent_market' => $percentChangeMarket,
                'percent_volume' => $percentChangeVolume,
                'percent_btc' => $percentChangeBtc,
                'percent_usd' => $percentChangeUsd,
                'btc_s' => $btcPerSecond,
                'usd_s' => $usdPerSecond,
                'speed' => $speed,
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

        $name = (string) $coin['name'];
        $symbol = (string) $coin['id'];
        $priceUsd = (float) $coin['price_usd'];
        $priceBtc = (float) $coin['price_btc'];
        $volume = (float) $coin['24h_volume_usd'];
        $supply = $coin['available_supply'];
        $marketCap = $coin['market_cap_usd'];
        // $percentChangeVolume = (float) 0;
        // $percentChangeBtc = (float) 0;
        // $percentChangeUsd = (float) 0;

        $databaseCoin = Coin::with('pricesOfToday')->where('symbol', '=', $symbol)->first();

        if (is_null($databaseCoin)) {
            $coin = Coin::create(['name' => $name, 'symbol' => $symbol]);

            Price::create(
                [
                    'coin_id' => $coin->id,
                    'price_btc' => $priceBtc,
                    'price_usd' => $priceUsd,
                    'volume' => $volume,
                    'supply' => $supply,
                    'market_cap' => $marketCap,
                    'percent_market' => 0,
                    'percent_volume' => 0,
                    'percent_btc' => 0,
                    'percent_usd' => 0,
                    'btc_s' => 0,
                    'usd_s' => 0,
                    'speed' => 0,
                ]
            );
        } else {
            if ($databaseCoin->pricesOfToday->isEmpty()) {
                $price = Price::create(
                    [
                        'coin_id' => $databaseCoin->id,
                        'price_btc' => $priceBtc,
                        'price_usd' => $priceUsd,
                        'volume' => $volume,
                        'supply' => $supply,
                        'market_cap' => $marketCap,
                        'percent_market' => 0,
                        'percent_volume' => 0,
                        'percent_btc' => 0,
                        'percent_usd' => 0,
                        'btc_s' => 0,
                        'usd_s' => 0,
                        'speed' => 0,
                    ]
                );
            } else {
                $firstOfToday = $databaseCoin->pricesOfToday->first();

                // dd($firstOfToday);
                $latestOfToday = $databaseCoin->pricesOfToday->last();

                // $firstOfToday = $databaseCoin['pricesOfToday'];
                // $latestOfToday = $databaseCoin->pricesOfToday->last();

                // $firstPriceOfToday = $databaseCoin->firstPriceOfToday();

                // echo ($coin->startOfDay($startOfDay)['volume']);

                // $wantedCoin = $coin->firstPrice()->where('created_at', '>', $startOfDay)->get()->last()->price_usd;

                // dd($databaseCoin->prices);

                // dd($firstOfToday->market_cap, $latestOfToday->market_cap);

                $firstMarketCap = $firstOfToday->market_cap;
                $firstVolume = $firstOfToday->volume;
                $firstBtcPrice = $firstOfToday->price_btc;
                $firstUsdPrice = $firstOfToday->price_usd;

                $percentChangeMarket = getPercentChange($firstMarketCap, $marketCap);
                $percentChangeVolume = getPercentChange($firstVolume, $volume);
                $percentChangeBtc = getPercentChange($firstBtcPrice, $priceBtc);
                $percentChangeUsd = getPercentChange($firstUsdPrice, $priceUsd);

                // $previousBtcPrice = (float) $datadatabaseCoin->prices()->latest()->first()->priceBtc;
                $previousBtcPrice = (float) $latestOfToday->price_btc;
                // dd($previousBtcPrice);
                $previousUsdPrice = (float) $latestOfToday->price_usd;

                $previousVolume = (float) $latestOfToday->volume;

                $duration = Carbon::now()->diffInSeconds($latestOfToday->created_at);

                $btcPerSecond = ($priceBtc - $previousBtcPrice) / $duration;
                $usdPerSecond = ($priceUsd - $previousUsdPrice) / $duration;

                $speed = getSpeed($priceUsd, $previousUsdPrice, $volume, $previousVolume);

                // dd($previousBtcPrice, $priceBtc, $duration);

                // dd($previousUsdPrice, $priceUsd, $usdPerSecond);

                $price = Price::create(
                    [
                        'coin_id' => $databaseCoin->id,
                        'price_btc' => $priceBtc,
                        'price_usd' => $priceUsd,
                        'volume' => $volume,
                        'supply' => $supply,
                        'market_cap' => $marketCap,
                        'percent_market' => $percentChangeMarket,
                        'percent_volume' => $percentChangeVolume,
                        'percent_btc' => $percentChangeBtc,
                        'percent_usd' => $percentChangeUsd,
                        'btc_s' => $btcPerSecond,
                        'usd_s' => $usdPerSecond,
                        'speed' => $speed,
                    ]
                );
            }
        }
    }

    return back();
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

function getSpeed($price, $previousPrice, $volume, $previousVolume)
{
    if ($volume - $previousVolume == 0) {
        return (float) 0;
    } elseif ($price > $previousPrice && $volume > $previousVolume) {
        return abs(($price - $previousPrice) / ($volume - $previousVolume)) * 100000;
    } elseif ($price < $previousPrice && $volume < $previousVolume) {
        return -abs(($price - $previousPrice) / ($volume - $previousVolume)) * 100000;
    } elseif ($price < $previousPrice || $volume > $previousVolume) {
        return -abs(($price - $previousPrice) / ($volume - $previousVolume)) * 100000;
    } else {
        return -abs(($price - $previousPrice) / ($volume - $previousVolume)) * 100000;
    }
}

Route::get('/', 'CoinsController@index');
Route::get('/{symbol}', 'CoinsController@show');
Route::get('/{symbol}/detail', 'CoinsController@detail');
