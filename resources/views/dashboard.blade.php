@extends('layouts.app')
@section('content')
    <style>
        ul {
            padding: 0;
            list-style: none;
        }

        li {
            margin: 20px;
        }
    </style>
    <div style="margin-top: 30px;" class="row">
        <div class="col-md-12">
            <h2>Dashboard</h2>
        </div>
    </div>
    <hr>
    <div style="margin-top: 30px;" class="row">
        <div class="col-md-12">
            <ul>
                @foreach($cars as $car)
                    <li>
                        <div>
                            <a href="{!! route('details',$car->id) !!}"><img width="200" height="200"
                                             src="{!! env('PINATA_IPFIS_URL','https://gateway.pinata.cloud/ipfs/').$car->url !!}"
                                             alt="">
                            </a>
                        </div>
                        <div><h3>{!! $car->name !!}</h3></div>
                        <div><h4>Price: ETH {!! $car->price !!}</h4></div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection