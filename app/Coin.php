<?php

namespace App;

use App\Price;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    protected $fillable = ['id', 'name', 'symbol'];

    public function prices()
    {
        return $this->hasMany(Price::class);
    }

    public function latestFirst()
    {
        return $this->prices()->orderBy('created_at', 'desc');
    }

    public function firstPriceOfToday()
    {
        return $this->prices()->where('created_at', '>', Carbon::today())->get()->first();
    }

    public function startOfDay($startOfDay)
    {
        return $this->prices()->startOfDay();
    }
}
