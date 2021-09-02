@extends('layouts.admin')
@section('content')
    <div style="margin-top: 30px;" class="row">
        <div class="col-md-12">
            <h2>Add Car</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 offset-3">
            <form method="POST" action="{!! route('addedCar') !!}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="form-group">
                    <label for="vin">VIN</label>
                    <input type="number" class="form-control" id="vin" name="vin">
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" class="form-control" id="price" name="price">
                </div>
                <div class="form-group">
                    <label for="url">Image</label>
                    <input type="file" class="form-control" id="url" name="url">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

@endsection