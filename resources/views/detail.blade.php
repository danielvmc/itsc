@extends('layout')

@section('content')
    <a class="text-left custom-text" href="/">Back</a><div class="help-block"></div><a class="custom-text" href="/update">Update</a><br>
    In last {{ $duration }}(s)
    @if($percentBtc < 0)
        <p>BTC price decreased<span class="text-danger"> {{ $percentBtc }}(%) </span></p>
    @else
        <p>BTC price increased<span class="text-success"> {{ $percentBtc }}(%) </span></p>
    @endif
    @if($percentUsd < 0)
        <p>USD price decreased<span class="text-danger"> {{ $percentUsd }}(%) </span></p>
    @else
        <p>USD price increased<span class="text-success"> {{ $percentUsd }}(%) </span></p>
    @endif
    @if($percentVolume < 0)
        <p>Volume price decreased<span class="text-danger"> {{ $percentVolume }}(%) </span></p>
    @else
        <p>Volume price increased<span class="text-success"> {{ $percentVolume }}(%) </span></p>
    @endif
    @if($percentMarketCap < 0)
        <p>Market Cap price decreased<span class="text-danger"> {{ $percentMarketCap }}(%) </span></p>
    @else
        <p>Market Cap price increased<span class="text-success"> {{ $percentMarketCap }}(%) </span></p>
    @endif
    <table id="shortable" class="table table-bordered" cellspacing="0" width="100%"
        <thead>
            <tr>
                <th class="fit">Time</th>
                <th class="fit">Price BTC</th>
                <th class="fit">Price USD</th>
                <th class="fit">Volume</th>
                <th class="fit">Supply</th>
                <th class="fit">Market Cap</th>
                <th class="fit">Market Cap
                 (%)</th>
                <th class="fit">Volume (%)</th>
                <th class="fit">BTC (%)</th>
                <th class="fit">USD (%)</th>
                <th class="fit">BTC/s</th>
                <th class="fit">USD/s</th>
            </tr>
        </thead>
        <tbody>
            <tr class="bg-success">
                <th scope="row" class="fit">Begin of today</th>
                <td class="fit">{{ number_format($firstPriceOfToday->price_btc, 10) }}</td>
                <td class="fit">{{ number_format($firstPriceOfToday->price_usd, 5) }}</td>
                <td class="fit">${{ number_format($firstPriceOfToday->volume) }}</td>
                <td class="fit">{{ number_format($firstPriceOfToday->supply) }}</td>
                <td class="fit">{{ number_format($firstPriceOfToday->market_cap) }}</td>
                <td class="fit">
                    @if($firstPriceOfToday->percent_market < 0)
                        <p class="text-danger text-right">{{ number_format($firstPriceOfToday->percent_market, 10) }}</p>
                    @else
                        <p class="text-success text-right">{{ number_format($firstPriceOfToday->percent_market, 10) }}</p>
                    @endif
                </td>
                <td class="fit">
                    @if($firstPriceOfToday->percent_volume < 0)
                        <p class="text-danger text-right">{{ number_format($firstPriceOfToday->percent_volume, 10) }}</p>
                    @else
                        <p class="text-success text-right">{{ number_format($firstPriceOfToday->percent_volume, 10) }}</p>
                    @endif
                </td>
                <td class="fit">
                    @if($firstPriceOfToday->percent_btc < 0)
                        <p class="text-danger text-right">{{ number_format($firstPriceOfToday->percent_btc, 10) }}</p>
                    @else
                        <p class="text-success text-right">{{ number_format($firstPriceOfToday->percent_btc, 10) }}</p>
                    @endif
                </td>
                <td class="fit">
                    @if($firstPriceOfToday->percent_usd < 0)
                        <p class="text-danger text-right">{{ number_format($firstPriceOfToday->percent_usd, 10) }}</p>
                    @else
                        <p class="text-success text-right">{{ number_format($firstPriceOfToday->percent_usd, 10) }}</p>
                    @endif
                </td>
                <td class="fit">
                    @if($firstPriceOfToday->percent_btc < 0)
                        <p class="text-danger text-right">{{ number_format($firstPriceOfToday->percent_btc, 10) }}</p>
                    @else
                        <p class="text-success text-right">{{ number_format($firstPriceOfToday->percent_btc, 10) }}</p>
                    @endif
                </td>
                <td class="fit">
                    @if($firstPriceOfToday->percent_usd < 0)
                        <p class="text-danger text-right">{{ number_format($firstPriceOfToday->percent_usd, 10) }}</p>
                    @else
                        <p class="text-success text-right">{{ number_format($firstPriceOfToday->percent_usd, 10) }}</p>
                    @endif
                </td>
            </tr>
            @foreach($coinPrices as $coin)
                <tr>
                    <th scope="row" class="fit">{{ $coin->created_at->diffForHumans() }}</th>
                    <td class="fit">{{ number_format($coin->price_btc, 10) }}</td>
                    <td class="fit">{{ number_format($coin->price_usd, 5) }}</td>
                    <td class="fit">${{ number_format($coin->volume) }}</td>
                    <td class="fit">{{ number_format($coin->supply) }}</td>
                    <td class="fit">{{ number_format($coin->market_cap) }}</td>
                    <td class="fit">
                        @if($coin->percent_market < 0)
                            <p class="text-danger text-right">{{ number_format($coin->percent_market, 10) }}</p>
                        @else
                            <p class="text-success text-right">{{ number_format($coin->percent_market, 10) }}</p>
                        @endif
                    </td>
                    <td class="fit">
                        @if($coin->percent_volume < 0)
                            <p class="text-danger text-right">{{ number_format($coin->percent_volume, 10) }}</p>
                        @else
                            <p class="text-success text-right">{{ number_format($coin->percent_volume, 10) }}</p>
                        @endif
                    </td>
                    <td class="fit">
                        @if($coin->percent_btc < 0)
                            <p class="text-danger text-right">{{ number_format($coin->percent_btc, 10) }}</p>
                        @else
                            <p class="text-success text-right">{{ number_format($coin->percent_btc, 10) }}</p>
                        @endif
                    </td>
                    <td class="fit">
                        @if($coin->percent_usd < 0)
                            <p class="text-danger text-right">{{ number_format($coin->percent_usd, 10) }}</p>
                        @else
                            <p class="text-success text-right">{{ number_format($coin->percent_usd, 10) }}</p>
                        @endif
                    </td>
                    <td class="fit">
                        @if($coin->btc_s < 0)
                            <p class="text-danger text-right">{{ number_format($coin->btc_s, 10) }}</p>
                        @else
                            <p class="text-success text-right">{{ number_format($coin->btc_s, 10) }}</p>
                        @endif
                    </td>
                    <td class="fit">
                        @if($coin->usd_s < 0)
                            <p class="text-danger text-right">{{ number_format($coin->usd_s, 10) }}</p>
                        @else
                            <p class="text-success text-right">{{ number_format($coin->usd_s, 10) }}</p>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
