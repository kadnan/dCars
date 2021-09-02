@extends('layouts.app')
@section('content')
    <div style="margin-top: 30px" class="row">
        <div class="col-md-2">
            <img height="300" width="300" class="" src="{!! asset('uploads/mustang-2.jpeg') !!}" alt="">
        </div>
        <div class="col-md-6 offset-2">
            <div><h2>Toyota Camry</h2></div>
            <div><h4>Price: 2 ETH</h4></div>
            <div><span>VIN: 3030303030</span></div>
            <div>
                <button class="btn btn-primary">Reserve</button>
                <button class="btn btn-danger">BUY</button>
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
@endsection