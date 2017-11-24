@extends('layout')

@section('content')
    <table id="shortable" class="table table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Coin Name</th>
                <th class="fit">Price BTC</th>
                <th class="fit">Price USD</th>
                <th class="fit">Volume</th>
                <th class="fit">Supply</th>
                <th class="fit">Change BTC (%)</th>
                <th class="fit">Change USD (%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($coins as $coin)
                <tr>
                    <th scope="row"><a href="{{ $coin->symbol }}">{{ $coin->name }}</a></th>
                    <td class="fit text-right">{{ number_format($coin->latestPrice[0]->price_btc, 10) }}</td>
                    <td class="fit text-right">{{ number_format($coin->latestPrice[0]->price_usd, 5) }}</td>
                    <td class="fit text-right">{{ number_format($coin->latestPrice[0]->volume) }}</td>
                    <td class="fit text-right">{{ number_format($coin->latestPrice[0]->supply) }}</td>
                    <td class="fit">
                        @if($coin->latestPrice[0]->percent_change_btc < 0)
                            <p class="text-danger text-right">{{ number_format($coin->latestPrice[0]->percent_change_btc, 10) }}</p>
                        @else
                            <p class="text-success text-right">{{ number_format($coin->latestPrice[0]->percent_change_btc, 10) }}</p>
                        @endif
                    </td>
                    <td class="fit">
                        @if($coin->latestPrice[0]->percent_change_usd < 0)
                            <p class="text-danger text-right">{{ number_format($coin->latestPrice[0]->percent_change_usd, 10) }}</p>
                        @else
                            <p class="text-success text-right">{{ number_format($coin->latestPrice[0]->percent_change_usd, 10) }}</p>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
