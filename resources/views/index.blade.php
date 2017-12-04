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
                <th class="fit">Market Cap</th>
                <th class="fit">Volume (%)</th>
                <th class="fit">BTC (%)</th>
                <th class="fit">USD (%)</th>
                <th class="fit">BTC/s</th>
                <th class="fit">USD/s</th>

            </tr>
        </thead>
        <tbody>
            @foreach($coins as $coin)
                <tr>
                    <th scope="row"><a href="{{ $coin->symbol }}">{{ $coin->name }}</a></th>
                    <td class="fit text-right">{{ number_format($coin->latestFirst[0]['price_btc'], 10) }}</td>
                    <td class="fit text-right">{{ number_format($coin->latestFirst[0]['price_usd'], 5) }}</td>
                    <td class="fit text-right">${{ number_format($coin->latestFirst[0]['volume']) }}</td>
                    <td class="fit text-right">{{ number_format($coin->latestFirst[0]['supply']) }}</td>
                    <td class="fit text-right">{{ number_format($coin->latestFirst[0]['market_cap']) }}</td>
                    <td class="fit">
                        @if($coin->latestFirst[0]['percent_volume'] < 0)
                            <p class="text-danger text-right">{{ number_format($coin->latestFirst[0]['percent_volume'], 10) }}</p>
                        @else
                            <p class="text-success text-right">{{ number_format($coin->latestFirst[0]['percent_volume'], 10) }}</p>
                        @endif
                    </td>
                    <td class="fit">
                        @if($coin->latestFirst[0]['percent_btc'] < 0)
                            <p class="text-danger text-right">{{ number_format($coin->latestFirst[0]['percent_btc'], 10) }}</p>
                        @else
                            <p class="text-success text-right">{{ number_format($coin->latestFirst[0]['percent_btc'], 10) }}</p>
                        @endif
                    </td>
                    <td class="fit">
                        @if($coin->latestFirst[0]['percent_usd'] < 0)
                            <p class="text-danger text-right">{{ number_format($coin->latestFirst[0]['percent_usd'], 10) }}</p>
                        @else
                            <p class="text-success text-right">{{ number_format($coin->latestFirst[0]['percent_usd'], 10) }}</p>
                        @endif
                    </td>
                    <td class="fit">
                        @if($coin->latestFirst[0]['btc_s'] < 0)
                            <p class="text-danger text-right">{{ number_format($coin->latestFirst[0]['btc_s'], 10) }}</p>
                        @else
                            <p class="text-success text-right">{{ number_format($coin->latestFirst[0]['btc_s'], 10) }}</p>
                        @endif
                    </td>
                    <td class="fit">
                        @if($coin->latestFirst[0]['usd_s'] < 0)
                            <p class="text-danger text-right">{{ number_format($coin->latestFirst[0]['usd_s'], 10) }}</p>
                        @else
                            <p class="text-success text-right">{{ number_format($coin->latestFirst[0]['usd_s'], 10) }}</p>
                        @endif
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
