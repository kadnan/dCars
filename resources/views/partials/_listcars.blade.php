<ul>
    @foreach($cars as $car)
        <li>
            <div class="card" style="width:400px">
                <img width="200" class="card-img-top" src="https://gateway.pinata.cloud/ipfs/{!! $car->url !!}" alt="Card image">
                <div class="card-body">
                    <h4 class="card-title">{!! $car->name !!}</h4>
                    <div><small>VIN: {!! $car->vin !!}</small></div>
                    <p class="card-text"><b>{!! $car->price !!} ETH</b></p>
                    <div class="text-center">
                        <a href="{!! route('details',$car->id) !!}" class="btn btn-info">View Details</a>
                    </div>

                </div>
            </div>
        </li>
    @endforeach
</ul>