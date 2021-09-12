@extends('layouts.app')
@section('content')
    @php
        $wallet_address = "";
    @endphp
    @if(\Session::has('wallet_address'))
        @php
            $wallet_address = \Session::get('wallet_address')
        @endphp
    @endif
    <div style="margin-top: 30px" class="row">
        <div class="col-md-2">
            <img height="300" width="300" class=""
                 src="{!! env('PINATA_IPFIS_URL','https://gateway.pinata.cloud/ipfs/').$car->url !!}" alt="">
        </div>
        <div class="col-md-6 offset-2">
            <div><h2>{!! $car->name !!}</h2></div>
            <div><h4>Price: {!! $car->price !!} ETH</h4></div>
            <div><span>VIN: {!! $car->vin !!}</span></div>
            <div>
                <button id="btnReserved" data-carid="{!! $car->id !!}"
                        title="{!! ($isReserved?'Already Reserved':'Click to reserve') !!}"
                        {!! ($isReserved?'disabled':'') !!} class="btn btn-primary">Reserve
                </button>
                <button data-price="{!! $car->price !!}" data-nftid = "{!! $nft_id !!}" data-carid="{!! $car->id !!}" data-wallet="{!! $wallet_address !!}" id="btnBuy" class="btn btn-danger">BUY</button>
            </div>
        </div>
    </div>
    <div style="margin-top: 100px;" class="row">
        <div class="col-md-12">
            <h3>History</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Event</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Transfer</td>
                    <td>0xa394...</td>
                    <td>0xvf94...</td>
                    <td>12-04-21</td>
                </tr>
                <tr>
                    <td>Mint</td>
                    <td>0xa394...</td>
                    <td>0xvf94...</td>
                    <td>12-04-21</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script>

    </script>
@endsection