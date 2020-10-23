@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <img class="card-img-top" src="{{asset($book->takeImage())}}" alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title">{{$book->title}}</h5>
            <p class="card-text">{{$book->description}}</p>
            <h6 class="card-subtitle mb-2 text-muted">IDR {{$book->price}} .00</h6>
        </div>
    </div>
</div>
@endsection
