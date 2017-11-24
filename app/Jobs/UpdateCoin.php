<?php

namespace App\Jobs;

use App\Coin;
use App\Price;
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

            $startOfDay = Carbon::today();

            $wantedCoin = $coin->firstPrice()->where('created_at', '>', $startOfDay)->get()->last()->price_usd;

            $lastBtcPrice = (float) $coin->firstPrice()->where('created_at', '>', $startOfDay)->get()->last()->price_btc;
            $lastUsdPrice = (float) $coin->firstPrice()->where('created_at', '>', $startOfDay)->get()->last()->price_usd;

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
    }
}
