@extends('layouts.app')
<style>
    ul {
        list-style: none;
        padding: 0px;

        -webkit-column-count: 2;
        -moz-column-count: 2;
        column-count: 2;
    }

    li {
        margin: 50px;
        display: inline-block;
    }
</style>
@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('partials._listcars')
        </div>
    </div>
@endsection