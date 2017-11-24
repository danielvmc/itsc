<?php

use App\Coin;
use App\Price;
use Carbon\Carbon;
use Unirest\Request;
use GuzzleHttp\Client;

function getPercentageChange($oldNumber, $newNumber)
{
    $changeValue = $newNumber - $oldNumber;

    return (float) ($changeValue / $oldNumber) * 100;
}

Route::get('/instant', function () {
    $response = Request::get('https://api.coinmarketcap.com/v1/ticker/?limit=2000');

    $coins = json_decode(json_encode($response->body));

    foreach ($coins as $coin) {
        $coin = (array) json_decode(json_encode($coin));

        $name = (string) $coin['name'];
        $symbol = (string) $coin['id'];

        $priceUsd = $coin['price_usd'];
        $priceBtc = $coin['price_btc'];
        $volume = $coin['24h_volume_usd'];
        $supply = $coin['available_supply'];
        $percentChangeBtc = (float) 0;
        $percentChangeUsd = (float) 0;

        $coin = Coin::create(['name' => $name, 'symbol' => $symbol]);

        Price::create(
            [
                'coin_id' => $coin->id,
                'price_btc' => $priceBtc,
                'price_usd' => $priceUsd,
                'volume' => $volume,
                'supply' => $supply,
                'percent_change_btc' => $percentChangeBtc,
                'percent_change_usd' => $percentChangeUsd,
            ]
        );
    }
});

Route::get('/', function () {
    $coins = Coin::with('latestPrice')->get();

    return view('index', compact('coins'));
    // $coins = ['bitcoin', 'ethereum', 'bitcoin-cash', 'ripple', 'ethereum-classic', 'digibyte'];

    // foreach ($coins as $coin) {
    //     $response = Request::get('https://api.coinmarketcap.com/v1/ticker/' . $coin);

    //     $content = (array) json_decode(json_encode($response->body[0]));

    //     var_dump($content);

    //     $name = $content['name'];
    //     $symbol = $content['id'];

    //     $priceUsd = $content['price_usd'];
    //     $priceBtc = $content['price_btc'];
    //     $volume = $content['24h_volume_usd'];
    //     $supply = $content['available_supply'];
    //     $percentChangeBtc = (float) 0;
    //     $percentChangeUsd = (float) 0;
    //     echo $volume;

    //     $coin = Coin::create(['name' => $name, 'symbol' => $symbol]);
    //     Price::create(
    //         [
    //             'coin_id' => $coin->id,
    //             'price_btc' => $priceBtc,
    //             'price_usd' => $priceUsd,
    //             'volume' => $volume,
    //             'supply' => $supply,
    //             'percent_change_btc' => $percentChangeBtc,
    //             'percent_change_usd' => $percentChangeUsd,
    //         ]
    //     );
    // }

    // // echo 'done';
    // echo $volume;

    // $response = Request::get('https://api.coinmarketcap.com/v1/ticker/bitcoin');

    // $content = (array) json_decode(json_encode($response->body[0]));

    // echo $content['24h_volume_usd'];

    // var_dump($content['24h_volume_usd']);
});

Route::get('update', function () {
    // $coins = ['bitcoin', 'ethereum', 'bitcoin-cash', 'ripple', 'ethereum-classic', 'digibyte'];

    // foreach ($coins as $coin) {
    //     $response = Request::get('https://api.coinmarketcap.com/v1/ticker/' . $coin);

    //     $content = (array) json_decode(json_encode($response->body[0]));

    //     $coin = Coin::where('symbol', '=', $coin)->first();

    //     $lastBtcPrice = (float) $coin->prices()->first()->price_btc;
    //     $lastUsdPrice = (float) $coin->prices()->first()->price_usd;

    //     $priceUsd = $content['price_usd'];
    //     $priceBtc = $content['price_btc'];
    //     $volume = $content['24h_volume_usd'];
    //     $supply = $content['available_supply'];

    //     $percentChangeBtc = getPercentageChange($lastBtcPrice, $priceBtc);
    //     $percentChangeUsd = getPercentageChange($lastUsdPrice, $priceUsd);

    //     Price::create(
    //         [
    //             'coin_id' => $coin->id,
    //             'price_btc' => $priceBtc,
    //             'price_usd' => $priceUsd,
    //             'volume' => $volume,
    //             'supply' => $supply,
    //             'percent_change_btc' => $percentChangeBtc,
    //             'percent_change_usd' => $percentChangeUsd,
    //         ]
    //     );
    // }

    $response = Request::get('https://api.coinmarketcap.com/v1/ticker/?limit=2000');

    $coins = json_decode(json_encode($response->body));

    foreach ($coins as $coin) {
        $coin = (array) json_decode(json_encode($coin));

        $symbol = (string) $coin['id'];

        $priceUsd = $coin['price_usd'];
        $priceBtc = $coin['price_btc'];
        $volume = $coin['24h_volume_usd'];
        $supply = $coin['available_supply'];
        $percentChangeBtc = (float) 0;
        $percentChangeUsd = (float) 0;

        $coin = Coin::where('symbol', '=', $symbol)->first();

        $startOfDay = Carbon::startOfDay();

        $lastBtcPrice = (float) $coin->prices()->first()->price_btc;
        $lastUsdPrice = (float) $coin->prices()->first()->price_usd;

        $percentChangeBtc = getPercentageChange($lastBtcPrice, $priceBtc);
        $percentChangeUsd = getPercentageChange($lastUsdPrice, $priceUsd);

        Price::create(
            [
                'coin_id' => $coin->id,
                'price_btc' => $priceBtc,
                'price_usd' => $priceUsd,
                'volume' => $volume,
                'supply' => $supply,
                'percent_change_btc' => $percentChangeBtc,
                'percent_change_usd' => $percentChangeUsd,
            ]
        );
    }

    echo 'done';
});

Route::get('/{symbol}', function ($symbol) {
    $coin = Coin::where('symbol', '=', $symbol)->first();
    $coinPrices = $coin->prices()->get();

    return view('detail', compact('coinPrices'));
});
