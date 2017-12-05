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

        return view('show', compact('coinPrices', 'firstPriceOfToday', 'duration', 'percentBtc', 'percentUsd', 'percentVolume', 'percentMarketCap'));
    }

    public function detail($symbol)
    {
        $coin = Coin::where('symbol', '=', $symbol)->first();

        $firstPriceOfToday = $coin->pricesOfToday->first();

        $tenPrices = $coin->pricesOfToday->reverse()->take(10)->reverse();

        $one = $tenPrices->shift();
        $two = $tenPrices->shift();
        $three = $tenPrices->shift();
        $four = $tenPrices->shift();
        $five = $tenPrices->shift();
        $six = $tenPrices->shift();
        $seven = $tenPrices->shift();
        $eight = $tenPrices->shift();
        $nine = $tenPrices->shift();
        $last = $tenPrices->shift();

        // $results = [];

        // $tenPrices->each(function ($price) {
        // });
        // 1
        $oneBtcPrice = (float) $one->price_btc;
        $oneUsdPrice = (float) $one->price_usd;
        $oneVolume = (float) $one->volume;
        $oneMarketCap = (float) $one->market_cap;

        // 2
        $twoBtcPrice = (float) $two->price_btc;
        $twoUsdPrice = (float) $two->price_usd;
        $twoVolume = (float) $two->volume;
        $twoMarketCap = (float) $two->market_cap;

        // 3
        $threeBtcPrice = (float) $three->price_btc;
        $threeUsdPrice = (float) $three->price_usd;
        $threeVolume = (float) $three->volume;
        $threeMarketCap = (float) $three->market_cap;

        $fourBtcPrice = (float) $four->price_btc;
        $fourUsdPrice = (float) $four->price_usd;
        $fourVolume = (float) $four->volume;
        $fourMarketCap = (float) $four->market_cap;

        $fiveBtcPrice = (float) $five->price_btc;
        $fiveUsdPrice = (float) $five->price_usd;
        $fiveVolume = (float) $five->volume;
        $fiveMarketCap = (float) $five->market_cap;

        $sixBtcPrice = (float) $six->price_btc;
        $sixUsdPrice = (float) $six->price_usd;
        $sixVolume = (float) $six->volume;
        $sixMarketCap = (float) $six->market_cap;

        $sevenBtcPrice = (float) $seven->price_btc;
        $sevenUsdPrice = (float) $seven->price_usd;
        $sevenVolume = (float) $seven->volume;
        $sevenMarketCap = (float) $seven->market_cap;

        $eightBtcPrice = (float) $eight->price_btc;
        $eightUsdPrice = (float) $eight->price_usd;
        $eightVolume = (float) $eight->volume;
        $eightMarketCap = (float) $eight->market_cap;

        $nineBtcPrice = (float) $nine->price_btc;
        $nineUsdPrice = (float) $nine->price_usd;
        $nineVolume = (float) $nine->volume;
        $nineMarketCap = (float) $nine->market_cap;

        $lastBtcPrice = (float) $last->price_btc;
        $lastUsdPrice = (float) $last->price_usd;
        $lastVolume = (float) $last->volume;
        $lastMarketCap = (float) $last->market_cap;

        $changeBtcPriceOne = $lastBtcPrice - $oneBtcPrice;
        $changeUsdPriceOne = $lastUsdPrice - $oneUsdPrice;
        $changeVolumeOne = $lastVolume - $oneVolume;
        $changeMarketCapOne = $lastMarketCap - $oneMarketCap;

        $changeBtcPriceTwo = $lastBtcPrice - $twoBtcPrice;
        $changeUsdPriceTwo = $lastUsdPrice - $twoUsdPrice;
        $changeVolumeTwo = $lastVolume - $twoVolume;
        $changeMarketCapTwo = $lastMarketCap - $twoMarketCap;

        $changeBtcPriceThree = $lastBtcPrice - $threeBtcPrice;
        $changeUsdPriceThree = $lastUsdPrice - $threeUsdPrice;
        $changeVolumeThree = $lastVolume - $threeVolume;
        $changeMarketCapThree = $lastMarketCap - $threeMarketCap;

        $changeBtcPriceFour = $lastBtcPrice - $fourBtcPrice;
        $changeUsdPriceFour = $lastUsdPrice - $fourUsdPrice;
        $changeVolumeFour = $lastVolume - $fourVolume;
        $changeMarketCapFour = $lastMarketCap - $fourMarketCap;

        $changeBtcPriceFive = $lastBtcPrice - $fiveBtcPrice;
        $changeUsdPriceFive = $lastUsdPrice - $fiveUsdPrice;
        $changeVolumeFive = $lastVolume - $fiveVolume;
        $changeMarketCapFive = $lastMarketCap - $fiveMarketCap;

        $changeBtcPriceSix = $lastBtcPrice - $sixBtcPrice;
        $changeUsdPriceSix = $lastUsdPrice - $sixUsdPrice;
        $changeVolumeSix = $lastVolume - $sixVolume;
        $changeMarketCapSix = $lastMarketCap - $sixMarketCap;

        $changeBtcPriceSeven = $lastBtcPrice - $sevenBtcPrice;
        $changeUsdPriceSeven = $lastUsdPrice - $sevenUsdPrice;
        $changeVolumeSeven = $lastVolume - $sevenVolume;
        $changeMarketCapSeven = $lastMarketCap - $sevenMarketCap;

        $changeBtcPriceEight = $lastBtcPrice - $eightBtcPrice;
        $changeUsdPriceEight = $lastUsdPrice - $eightUsdPrice;
        $changeVolumeEight = $lastVolume - $eightVolume;
        $changeMarketCapEight = $lastMarketCap - $eightMarketCap;

        $changeBtcPriceNine = $lastBtcPrice - $nineBtcPrice;
        $changeUsdPriceNine = $lastUsdPrice - $nineUsdPrice;
        $changeVolumeNine = $lastVolume - $nineVolume;
        $changeMarketCapNine = $lastMarketCap - $nineMarketCap;

        $durationOne = $last->created_at->diffInSeconds($one->created_at);
        $durationTwo = $last->created_at->diffInSeconds($two->created_at);
        $durationThree = $last->created_at->diffInSeconds($three->created_at);
        $durationFour = $last->created_at->diffInSeconds($four->created_at);
        $durationFive = $last->created_at->diffInSeconds($five->created_at);
        $durationSix = $last->created_at->diffInSeconds($six->created_at);
        $durationSeven = $last->created_at->diffInSeconds($seven->created_at);
        $durationEight = $last->created_at->diffInSeconds($eight->created_at);
        $durationNine = $last->created_at->diffInSeconds($nine->created_at);

        $percentBtcOne = $this->getPercentChange($oneBtcPrice, $lastBtcPrice);
        $percentUsdOne = $this->getPercentChange($oneUsdPrice, $lastUsdPrice);
        $percentVolumeOne = $this->getPercentChange($oneVolume, $lastVolume);
        $percentMarketCapOne = $this->getPercentChange($oneMarketCap, $lastMarketCap);

        $percentBtcTwo = $this->getPercentChange($twoBtcPrice, $lastBtcPrice);
        $percentUsdTwo = $this->getPercentChange($twoUsdPrice, $lastUsdPrice);
        $percentVolumeTwo = $this->getPercentChange($twoVolume, $lastVolume);
        $percentMarketCapTwo = $this->getPercentChange($twoMarketCap, $lastMarketCap);

        $percentBtcThree = $this->getPercentChange($threeBtcPrice, $lastBtcPrice);
        $percentUsdThree = $this->getPercentChange($threeUsdPrice, $lastUsdPrice);
        $percentVolumeThree = $this->getPercentChange($threeVolume, $lastVolume);
        $percentMarketCapThree = $this->getPercentChange($threeMarketCap, $lastMarketCap);

        $percentBtcFour = $this->getPercentChange($fourBtcPrice, $lastBtcPrice);
        $percentUsdFour = $this->getPercentChange($fourUsdPrice, $lastUsdPrice);
        $percentVolumeFour = $this->getPercentChange($fourVolume, $lastVolume);
        $percentMarketCapFour = $this->getPercentChange($fourMarketCap, $lastMarketCap);

        $percentBtcFive = $this->getPercentChange($fiveBtcPrice, $lastBtcPrice);
        $percentUsdFive = $this->getPercentChange($fiveUsdPrice, $lastUsdPrice);
        $percentVolumeFive = $this->getPercentChange($fiveVolume, $lastVolume);
        $percentMarketCapFive = $this->getPercentChange($fiveMarketCap, $lastMarketCap);

        $percentBtcSix = $this->getPercentChange($sixBtcPrice, $lastBtcPrice);
        $percentUsdSix = $this->getPercentChange($sixUsdPrice, $lastUsdPrice);
        $percentVolumeSix = $this->getPercentChange($sixVolume, $lastVolume);
        $percentMarketCapSix = $this->getPercentChange($sixMarketCap, $lastMarketCap);

        $percentBtcSeven = $this->getPercentChange($sevenBtcPrice, $lastBtcPrice);
        $percentUsdSeven = $this->getPercentChange($sevenUsdPrice, $lastUsdPrice);
        $percentVolumeSeven = $this->getPercentChange($sevenVolume, $lastVolume);
        $percentMarketCapSeven = $this->getPercentChange($sevenMarketCap, $lastMarketCap);

        $percentBtcEight = $this->getPercentChange($eightBtcPrice, $lastBtcPrice);
        $percentUsdEight = $this->getPercentChange($eightUsdPrice, $lastUsdPrice);
        $percentVolumeEight = $this->getPercentChange($eightVolume, $lastVolume);
        $percentMarketCapEight = $this->getPercentChange($eightMarketCap, $lastMarketCap);

        $percentBtcNine = $this->getPercentChange($nineBtcPrice, $lastBtcPrice);
        $percentUsdNine = $this->getPercentChange($nineUsdPrice, $lastUsdPrice);
        $percentVolumeNine = $this->getPercentChange($nineVolume, $lastVolume);
        $percentMarketCapNine = $this->getPercentChange($nineMarketCap, $lastMarketCap);

        $coinPrices = $coin->latestFirst()->get();

        return view('detail', compact('durationOne', 'percentBtcOne', 'percentUsdOne', 'percentVolumeOne', 'percentMarketCapOne', 'durationTwo', 'percentBtcTwo', 'percentUsdTwo', 'percentVolumeTwo', 'percentMarketCapTwo', 'durationThree', 'percentBtcThree', 'percentUsdThree', 'percentVolumeThree', 'percentMarketCapThree', 'durationFour', 'percentBtcFour', 'percentUsdFour', 'percentVolumeFour', 'percentMarketCapFour', 'durationFive', 'percentBtcFive', 'percentUsdFive', 'percentVolumeFive', 'percentMarketCapFive', 'durationSix', 'percentBtcSix', 'percentUsdSix', 'percentVolumeSix', 'percentMarketCapSix', 'durationSeven', 'percentBtcSeven', 'percentUsdSeven', 'percentVolumeSeven', 'percentMarketCapSeven', 'durationEight', 'percentBtcEight', 'percentUsdEight', 'percentVolumeEight', 'percentMarketCapEight', 'durationNine', 'percentBtcNine', 'percentUsdNine', 'percentVolumeNine', 'percentMarketCapNine'));
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
