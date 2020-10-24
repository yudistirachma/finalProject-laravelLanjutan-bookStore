@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-7">
           <chat-box-component></chat-box-component>
        </div>
        <div class="col-md-4">
            <chat-user-list-component></chat-user-list-component>
        </div>
    </div>
</div>
@endsection
