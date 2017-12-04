<?php

namespace App;

use App\Coin;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = ['coin_id', 'price_btc', 'price_usd', 'volume', 'supply', 'market_cap', 'percent_volume', 'percent_btc', 'percent_usd'];

    public function coin()
    {
        return $this->belongsTo(Coin::class);
    }
}
