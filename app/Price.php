<?php

namespace App;

use App\Coin;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = ['coin_id', 'price_btc', 'price_usd', 'volume', 'supply', 'percent_change_btc', 'percent_change_usd'];

    public function coin()
    {
        return $this->belongsTo(Coin::class);
    }
}
