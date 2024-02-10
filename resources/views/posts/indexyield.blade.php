
@extends('layout')

@section('content')

    <div class="container mt-5">
        <div class="row">
            @foreach ($posts as $post)
                <div class="col-sm">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">{{ $post->title }}</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ $post->short_description }}</p>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ $post->description }}</p>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
