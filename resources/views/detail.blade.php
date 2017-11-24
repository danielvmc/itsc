@extends('layout')

@section('content')
    <a class="text-left custom-text" href="/">Back</a><br>
    <table id="shortable" class="table table-bordered" cellspacing="0" width="100%"
        <thead>
            <tr>
                <th class="fit">Time</th>
                <th class="fit">Price BTC</th>
                <th class="fit">Price USD</th>
                <th class="fit">Volume</th>
                <th class="fit">Supply</th>
                <th class="fit">Change BTC (%)</th>
                <th class="fit">Change USD (%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($coinPrices as $coin)
                <tr>
                    <th scope="row" class="fit">{{ $coin->created_at->diffForHumans() }}</th>
                    <td class="fit">{{ number_format($coin->price_btc, 10) }}</td>
                    <td class="fit">{{ number_format($coin->price_usd, 5) }}</td>
                    <td class="fit">${{ number_format($coin->volume) }}</td>
                    <td class="fit">{{ number_format($coin->supply) }}</td>
                    <td class="fit">
                        @if($coin->percent_change_btc < 0)
                            <p class="text-danger text-right">{{ number_format($coin->percent_change_btc, 10) }}</p>
                        @else
                            <p class="text-success text-right">{{ number_format($coin->percent_change_btc, 10) }}</p>
                        @endif
                    </td>
                    <td class="fit">
                        @if($coin->percent_change_usd < 0)
                            <p class="text-danger text-right">{{ number_format($coin->percent_change_usd, 10) }}</p>
                        @else
                            <p class="text-success text-right">{{ number_format($coin->percent_change_usd, 10) }}</p>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
