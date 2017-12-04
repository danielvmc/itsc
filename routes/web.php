<?php

use App\Coin;
use App\Price;
use Carbon\Carbon;
use Unirest\Request;
use GuzzleHttp\Client;

function getPercentageChange($oldNumber, $newNumber)
{
    if ($oldNumber == 0) {
        return (float) 0;
    } else {
        $changeValue = $newNumber - $oldNumber;

        return (float) ($changeValue / $oldNumber) * 100;
    }
}

Route::get('/test', function () {
    $response = Request::get('https://api.coinmarketcap.com/v1/ticker/bitcoin');
    $coin = (array) json_decode(json_encode($response->body[0]));
    $volume = (float) $coin['24h_volume_usd'];
    $btc = Price::where('coin_id', '=', 1)->first();
    $oldVolume = (float) $btc->volume;
    dd($volume, $oldVolume, getPercentageChange($oldVolume, $volume));
    dd(getPercentageChange($oldVolume, $volume));
});

Route::get('/instant', function () {
    $response = Request::get('https://api.coinmarketcap.com/v1/ticker/?limit=100');

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

    $response = Request::get('https://api.coinmarketcap.com/v1/ticker/?limit=100');

    $coins = json_decode(json_encode($response->body));

    foreach ($coins as $coin) {
        $coin = (array) json_decode(json_encode($coin));

        $symbol = (string) $coin['id'];

        $priceUsd = $coin['price_usd'];
        $priceBtc = $coin['price_btc'];
        $volume = (float) $coin['24h_volume_usd'];
        $supply = $coin['available_supply'];
        $marketCap = $coin['market_cap_usd'];
        // $percentChangeVolume = (float) 0;
        // $percentChangeBtc = (float) 0;
        // $percentChangeUsd = (float) 0;

        $coin = Coin::where('symbol', '=', $symbol)->first();

        $startOfDay = Carbon::today();

        // $wantedCoin = $coin->firstPrice()->where('created_at', '>', $startOfDay)->get()->last()->price_usd;

        $lastVolume = (float) $coin->firstPrice()->where('created_at', '>', $startOfDay)->get()->last()->volume;
        $lastBtcPrice = (float) $coin->firstPrice()->where('created_at', '>', $startOfDay)->get()->last()->price_btc;
        $lastUsdPrice = (float) $coin->firstPrice()->where('created_at', '>', $startOfDay)->get()->last()->price_usd;

        $percentChangeVolume = getPercentageChange($lastVolume, $volume);
        $percentChangeBtc = getPercentageChange($lastBtcPrice, $priceBtc);
        $percentChangeUsd = getPercentageChange($lastUsdPrice, $priceUsd);

        $price = Price::create(
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
            ]
        );
    }

    echo 'done';
});

Route::get('/{symbol}', function ($symbol) {
    $startOfDay = Carbon::today();
    $coin = Coin::where('symbol', '=', $symbol)->first();

    $firstPriceOfDay = $coin->firstPrice()->where('created_at', '>', $startOfDay)->get()->last();

    $coinPrices = $coin->prices()->get();

    return view('detail', compact('coinPrices', 'firstPriceOfDay'));
});
