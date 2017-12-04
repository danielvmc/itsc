<?php

namespace App\Jobs;

use App\Coin;
use App\Price;
use Carbon\Carbon;
use Unirest\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateCoin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
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
                    'percent_volume' => $percentChangeVolume,
                    'percent_btc' => $percentChangeBtc,
                    'percent_usd' => $percentChangeUsd,
                    'btc_s' => $btcPerSecond,
                    'usd_s' => $usdPerSecond,
                ]
            );
        }
    }
}
