@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="row">
            <div class="form-group col-md-4">
                <label for="Title">Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="Title" placeholder="Title" required> 
                @error('title')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="price">Price</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupPrepend2">RP</span>
                    </div>
                    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" id="price" aria-describedby="inputGroupPrepend2" required>
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroupPrepend2">.00</span>
                    </div>
                    @error('price')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-8">
                <label for="exampleFormControlTextarea1">Description</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="was-validated col-md-4">
                <div class="custom-file">
                    <input type="file" class="custom-file-input @error('picture') is-invalid @enderror" required id="validatedCustomFile" name="picture" >
                    <label class="custom-file-label" for="validatedCustomFile">Choose picture...</label>
                </div>
                @error('picture')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>
            <div class="col-md-4">
                <button class="btn btn-primary" type="submit">Submit Book</button>
            </div>
        </div>
    </form>
</div>
@endsection
