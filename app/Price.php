<?php

namespace App;

use App\Coin;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = ['coin_id', 'price_btc', 'price_usd', 'volume', 'supply', 'market_cap', 'percent_volume', 'percent_btc', 'percent_usd', 'btc_s', 'usd_s'];

    public function coin()
    {
        return $this->belongsTo(Coin::class);
    }

    public function firstPriceOfToday()
    {
        return $this->where('created_at', '>', Carbon::today())->orderBy('created_at', 'asc')->latest()->last();
    }

    public function startOfDay($startOfDay)
    {
        return $this->where('created_at', '>', Carbon::today())->get()->first();
    }
}
