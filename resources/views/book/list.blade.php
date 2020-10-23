@extends('layouts.app')

@section('content')
<div class="container">
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Price</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($books as $book)
            <tr>
                <th>{{$book->title}}</th>
                <td>{{Str::limit($book->description)}}</td>
                <td>{{$book->price}}</td>
                <td>
                    <a href="/{{$book->id}}/edit" class="btn btn-outline-warning btn-sm">Edit</a>
                    <form action="{{$book->id}}" method="POST" class="p-0 m-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
