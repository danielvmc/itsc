<?php

namespace App;

use App\Price;
use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    protected $fillable = ['id', 'name', 'symbol'];

    public function prices()
    {
        return $this->hasMany(Price::class)->orderBy('created_at', 'desc');
    }

    public function latestPrice()
    {
        return $this->prices()->latest();
    }

    public function firstPrice()
    {
        return $this->prices()->orderBy('created_at', 'asc');
    }
}
