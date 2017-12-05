@extends('layout')

@section('content')
    <a class="text-left custom-text" href="/">Back</a><div class="help-block"></div><a class="custom-text" href="/update">Update</a><br>
    In the last {{ $durationNine }}(s) period
    @if($percentBtcNine < 0)
        <p>BTC price decreased<span class="text-danger"> {{ $percentBtcNine }}(%) </span></p>
    @else
        <p>BTC price increased<span class="text-success"> {{ $percentBtcNine }}(%) </span></p>
    @endif
    @if($percentUsdNine < 0)
        <p>USD price decreased<span class="text-danger"> {{ $percentUsdNine }}(%) </span></p>
    @else
        <p>USD price increased<span class="text-success"> {{ $percentUsdNine }}(%) </span></p>
    @endif
    @if($percentVolumeNine < 0)
        <p>Volume price decreased<span class="text-danger"> {{ $percentVolumeNine }}(%) </span></p>
    @else
        <p>Volume price increased<span class="text-success"> {{ $percentVolumeNine }}(%) </span></p>
    @endif
    @if($percentMarketCapNine < 0)
        <p>Market Cap price decreased<span class="text-danger"> {{ $percentMarketCapNine }}(%) </span></p>
    @else
        <p>Market Cap price increased<span class="text-success"> {{ $percentMarketCapNine }}(%) </span></p>
    @endif
    -----------
    In the last {{ $durationEight }}(s) period
    @if($percentBtcEight < 0)
        <p>BTC price decreased<span class="text-danger"> {{ $percentBtcEight }}(%) </span></p>
    @else
        <p>BTC price increased<span class="text-success"> {{ $percentBtcEight }}(%) </span></p>
    @endif
    @if($percentUsdEight < 0)
        <p>USD price decreased<span class="text-danger"> {{ $percentUsdEight }}(%) </span></p>
    @else
        <p>USD price increased<span class="text-success"> {{ $percentUsdEight }}(%) </span></p>
    @endif
    @if($percentVolumeEight < 0)
        <p>Volume price decreased<span class="text-danger"> {{ $percentVolumeEight }}(%) </span></p>
    @else
        <p>Volume price increased<span class="text-success"> {{ $percentVolumeEight }}(%) </span></p>
    @endif
    @if($percentMarketCapEight < 0)
        <p>Market Cap price decreased<span class="text-danger"> {{ $percentMarketCapEight }}(%) </span></p>
    @else
        <p>Market Cap price increased<span class="text-success"> {{ $percentMarketCapEight }}(%) </span></p>
    @endif
    -----------
    In the last {{ $durationSeven }}(s) period
    @if($percentBtcSeven < 0)
        <p>BTC price decreased<span class="text-danger"> {{ $percentBtcSeven }}(%) </span></p>
    @else
        <p>BTC price increased<span class="text-success"> {{ $percentBtcSeven }}(%) </span></p>
    @endif
    @if($percentUsdSeven < 0)
        <p>USD price decreased<span class="text-danger"> {{ $percentUsdSeven }}(%) </span></p>
    @else
        <p>USD price increased<span class="text-success"> {{ $percentUsdSeven }}(%) </span></p>
    @endif
    @if($percentVolumeSeven < 0)
        <p>Volume price decreased<span class="text-danger"> {{ $percentVolumeSeven }}(%) </span></p>
    @else
        <p>Volume price increased<span class="text-success"> {{ $percentVolumeSeven }}(%) </span></p>
    @endif
    @if($percentMarketCapSeven < 0)
        <p>Market Cap price decreased<span class="text-danger"> {{ $percentMarketCapSeven }}(%) </span></p>
    @else
        <p>Market Cap price increased<span class="text-success"> {{ $percentMarketCapSeven }}(%) </span></p>
    @endif
    -----------
    In the last {{ $durationSix }}(s) period
    @if($percentBtcSix < 0)
        <p>BTC price decreased<span class="text-danger"> {{ $percentBtcSix }}(%) </span></p>
    @else
        <p>BTC price increased<span class="text-success"> {{ $percentBtcSix }}(%) </span></p>
    @endif
    @if($percentUsdSix < 0)
        <p>USD price decreased<span class="text-danger"> {{ $percentUsdSix }}(%) </span></p>
    @else
        <p>USD price increased<span class="text-success"> {{ $percentUsdSix }}(%) </span></p>
    @endif
    @if($percentVolumeSix < 0)
        <p>Volume price decreased<span class="text-danger"> {{ $percentVolumeSix }}(%) </span></p>
    @else
        <p>Volume price increased<span class="text-success"> {{ $percentVolumeSix}}(%) </span></p>
    @endif
    @if($percentMarketCapSix < 0)
        <p>Market Cap price decreased<span class="text-danger"> {{ $percentMarketCapSix }}(%) </span></p>
    @else
        <p>Market Cap price increased<span class="text-success"> {{ $percentMarketCapSix }}(%) </span></p>
    @endif
    -----------
    In the last {{ $durationFive }}(s) period
    @if($percentBtcFive < 0)
        <p>BTC price decreased<span class="text-danger"> {{ $percentBtcFive }}(%) </span></p>
    @else
        <p>BTC price increased<span class="text-success"> {{ $percentBtcFive }}(%) </span></p>
    @endif
    @if($percentUsdFive < 0)
        <p>USD price decreased<span class="text-danger"> {{ $percentUsdFive }}(%) </span></p>
    @else
        <p>USD price increased<span class="text-success"> {{ $percentUsdFive }}(%) </span></p>
    @endif
    @if($percentVolumeFive < 0)
        <p>Volume price decreased<span class="text-danger"> {{ $percentVolumeFive }}(%) </span></p>
    @else
        <p>Volume price increased<span class="text-success"> {{ $percentVolumeFive }}(%) </span></p>
    @endif
    @if($percentMarketCapFive < 0)
        <p>Market Cap price decreased<span class="text-danger"> {{ $percentMarketCapFive }}(%) </span></p>
    @else
        <p>Market Cap price increased<span class="text-success"> {{ $percentMarketCapFive }}(%) </span></p>
    @endif
    -----------
    In the last {{ $durationFour }}(s) period
    @if($percentBtcFour < 0)
        <p>BTC price decreased<span class="text-danger"> {{ $percentBtcFour }}(%) </span></p>
    @else
        <p>BTC price increased<span class="text-success"> {{ $percentBtcFour }}(%) </span></p>
    @endif
    @if($percentUsdFour < 0)
        <p>USD price decreased<span class="text-danger"> {{ $percentUsdFour }}(%) </span></p>
    @else
        <p>USD price increased<span class="text-success"> {{ $percentUsdFour }}(%) </span></p>
    @endif
    @if($percentVolumeFour < 0)
        <p>Volume price decreased<span class="text-danger"> {{ $percentVolumeFour }}(%) </span></p>
    @else
        <p>Volume price increased<span class="text-success"> {{ $percentVolumeFour }}(%) </span></p>
    @endif
    @if($percentMarketCapFour < 0)
        <p>Market Cap price decreased<span class="text-danger"> {{ $percentMarketCapFour }}(%) </span></p>
    @else
        <p>Market Cap price increased<span class="text-success"> {{ $percentMarketCapFour }}(%) </span></p>
    @endif
    -----------
    In the last {{ $durationThree }}(s) period
    @if($percentBtcThree < 0)
        <p>BTC price decreased<span class="text-danger"> {{ $percentBtcThree }}(%) </span></p>
    @else
        <p>BTC price increased<span class="text-success"> {{ $percentBtcThree }}(%) </span></p>
    @endif
    @if($percentUsdThree < 0)
        <p>USD price decreased<span class="text-danger"> {{ $percentUsdThree }}(%) </span></p>
    @else
        <p>USD price increased<span class="text-success"> {{ $percentUsdThree }}(%) </span></p>
    @endif
    @if($percentVolumeThree < 0)
        <p>Volume price decreased<span class="text-danger"> {{ $percentVolumeThree }}(%) </span></p>
    @else
        <p>Volume price increased<span class="text-success"> {{ $percentVolumeThree }}(%) </span></p>
    @endif
    @if($percentMarketCapThree < 0)
        <p>Market Cap price decreased<span class="text-danger"> {{ $percentMarketCapThree }}(%) </span></p>
    @else
        <p>Market Cap price increased<span class="text-success"> {{ $percentMarketCapThree }}(%) </span></p>
    @endif
    -----------
    In the last {{ $durationTwo }}(s) period
    @if($percentBtcTwo < 0)
        <p>BTC price decreased<span class="text-danger"> {{ $percentBtcTwo }}(%) </span></p>
    @else
        <p>BTC price increased<span class="text-success"> {{ $percentBtcTwo }}(%) </span></p>
    @endif
    @if($percentUsdTwo < 0)
        <p>USD price decreased<span class="text-danger"> {{ $percentUsdTwo }}(%) </span></p>
    @else
        <p>USD price increased<span class="text-success"> {{ $percentUsdTwo }}(%) </span></p>
    @endif
    @if($percentVolumeTwo < 0)
        <p>Volume price decreased<span class="text-danger"> {{ $percentVolumeTwo }}(%) </span></p>
    @else
        <p>Volume price increased<span class="text-success"> {{ $percentVolumeTwo }}(%) </span></p>
    @endif
    @if($percentMarketCapTwo < 0)
        <p>Market Cap price decreased<span class="text-danger"> {{ $percentMarketCapTwo }}(%) </span></p>
    @else
        <p>Market Cap price increased<span class="text-success"> {{ $percentMarketCapTwo }}(%) </span></p>
    @endif
    -----------
    In the last {{ $durationOne }}(s) period
    @if($percentBtcOne < 0)
        <p>BTC price decreased<span class="text-danger"> {{ $percentBtcOne }}(%) </span></p>
    @else
        <p>BTC price increased<span class="text-success"> {{ $percentBtcOne }}(%) </span></p>
    @endif
    @if($percentUsdOne < 0)
        <p>USD price decreased<span class="text-danger"> {{ $percentUsdOne }}(%) </span></p>
    @else
        <p>USD price increased<span class="text-success"> {{ $percentUsdOne }}(%) </span></p>
    @endif
    @if($percentVolumeOne < 0)
        <p>Volume price decreased<span class="text-danger"> {{ $percentVolumeOne }}(%) </span></p>
    @else
        <p>Volume price increased<span class="text-success"> {{ $percentVolumeOne }}(%) </span></p>
    @endif
    @if($percentMarketCapOne < 0)
        <p>Market Cap price decreased<span class="text-danger"> {{ $percentMarketCapOne }}(%) </span></p>
    @else
        <p>Market Cap price increased<span class="text-success"> {{ $percentMarketCapOne }}(%) </span></p>
    @endif
    -----------
@endsection
