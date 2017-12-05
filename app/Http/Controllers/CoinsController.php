<?php

namespace App\Http\Controllers;

use App\Coin;
use App\Price;
use Carbon\Carbon;
use Unirest\Request;

class CoinsController extends Controller
{
    public function index()
    {
        $coins = Coin::with('latestFirst')->get();

        // foreach ($coins as $coin) {
        //     echo $coin->latestFirst[0]['price_btc'];
        // }

        return view('index', compact('coins'));
    }

    public function show($symbol)
    {
        $coin = Coin::where('symbol', '=', $symbol)->first();

        $firstPriceOfToday = $coin->pricesOfToday->first();

        $twoLatest = $coin->pricesOfToday->reverse()->take(2)->reverse();

        $before = $twoLatest->first();
        $after = $twoLatest->last();

        $beforeBtcPrice = (float) $before->price_btc;
        $beforeUsdPrice = (float) $before->price_usd;
        $beforeVolume = (float) $before->volume;
        $beforeMarketCap = (float) $before->market_cap;

        $afterBtcPrice = (float) $after->price_btc;
        $afterUsdPrice = (float) $after->price_usd;
        $afterVolume = (float) $after->volume;
        $afterMarketCap = (float) $after->market_cap;

        $changeBtcPrice = $afterBtcPrice - $beforeBtcPrice;
        $changeUsdPrice = $afterUsdPrice - $beforeUsdPrice;
        $changeVolume = $afterVolume - $beforeVolume;
        $changeMarketCap = $afterMarketCap - $beforeMarketCap;

        $duration = $after->created_at->diffInSeconds($before->created_at);

        $percentBtc = $this->getPercentChange($beforeBtcPrice, $afterBtcPrice);
        $percentUsd = $this->getPercentChange($beforeUsdPrice, $afterUsdPrice);
        $percentVolume = $this->getPercentChange($beforeVolume, $afterVolume);
        $percentMarketCap = $this->getPercentChange($beforeMarketCap, $afterMarketCap);

        $coinPrices = $coin->latestFirst()->get();

        return view('detail', compact('coinPrices', 'firstPriceOfToday', 'duration', 'percentBtc', 'percentUsd', 'percentVolume', 'percentMarketCap'));
    }

    public function update()
    {
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

            $firstPriceOfToday = $databaseCoin->firstPriceOfToday();

            // echo ($coin->startOfDay($startOfDay)['volume']);

            // $wantedCoin = $coin->firstPrice()->where('created_at', '>', $startOfDay)->get()->last()->price_usd;

            $lastVolume = $databaseCoin->firstPriceOfToday()->volume;
            $lastBtcPrice = $databaseCoin->firstPriceOfToday()->price_btc;
            $lastUsdPrice = $databaseCoin->firstPriceOfToday()->price_usd;

            // $lastVolume = (float) $datadatabaseCoin->prices()->where('created_at', '>', $startOfDay)->latest()->first()->volume;
            // $lastBtcPrice = (float) $datadatabaseCoin->prices()->where('created_at', '>', $startOfDay)->latest()->first()->price_btc;
            // $lastUsdPrice = (float) $datadatabaseCoin->prices()->where('created_at', '>', $startOfDay)->latest()->first()->price_usd;
            // $lastBtcPrice = (float) $datadatabaseCoin->firstPrice()->where('created_at', '>', $startOfDay)->get()->last()->price_btc;
            // $lastUsdPrice = (float) $datadatabaseCoin->firstPrice()->where('created_at', '>', $startOfDay)->get()->last()->price_usd;

            $percentChangeVolume = $this->getPercentChange($lastVolume, $volume);
            $percentChangeBtc = $this->getPercentChange($lastBtcPrice, $priceBtc);
            $percentChangeUsd = $this->getPercentChange($lastUsdPrice, $priceUsd);

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
                    'percent_market' => $percentChange,
                    'percent_volume' => $percentChangeVolume,
                    'percent_btc' => $percentChangeBtc,
                    'percent_usd' => $percentChangeUsd,
                    'btc_s' => $btcPerSecond,
                    'usd_s' => $usdPerSecond,
                ]
            );
        }

        echo 'done';
    }

    private function getPercentChange($oldNumber, $newNumber)
    {
        if ($oldNumber == 0) {
            return (float) 0;
        } else {
            $changeValue = $newNumber - $oldNumber;

            return (float) ($changeValue / $oldNumber) * 100;
        }
    }
}
