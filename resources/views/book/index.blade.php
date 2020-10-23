@extends('layouts.app')

@section('content')
<div class="container">
    <div class=row>
        @foreach ($books as $book)
            <div class="card m-2" style="width: 18rem;">
                <img class="card-img-top" src="{{asset($book->takeImage())}}" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">{{$book->title}}</h5>
                    <p class="card-text font-weight-light"><span class="badge badge-light">Description</span> {{Str::limit($book->description)}}</p>
                    <a href="#" class="btn btn-primary">Buy <span class="badge badge-light">IDR {{$book->price}} .00</span></a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
