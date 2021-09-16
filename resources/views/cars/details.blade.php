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
                        {!! ($isReserved?'disabled':'') !!} {!! ($car->status == 4)? 'disabled':'' !!}  class="btn btn-primary d-none">Reserve
                </button>
                <button {!! ($car->status == 4)? 'disabled':'' !!} data-price="{!! $car->price !!}" data-nftid = "{!! $nft_id !!}" data-carid="{!! $car->id !!}" data-wallet="{!! $wallet_address !!}" id="btnBuy" class="btn btn-danger">BUY</button>
            </div>
            @if($isOwner)
                <div><span style="color: red; font-size: 16px; font-weight: bold;">You are the owner!</span></div>
            @endif
            @if($car->status == 4)
                <div><span style="color: green; font-size: 16px; font-weight: bold;">Owner:- {!! $owner_address !!}</span></div>
            @endif
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
                @foreach($history as $record)
                    <tr>
                        <td>{!! ucwords($record->event) !!}</td>
                        <td>{!! $record->from !!}</td>
                        <td>{!! $record->to !!}</td>
                        <td>{!! $record->created_at !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>

    </script>
@endsection