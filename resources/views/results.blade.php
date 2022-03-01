
@extends('layouts.main')

@section('container')
    <h1 class="mb-3 text-center">{{ $title }}</h1>
    <div class="container">
      <div class="row">
        @foreach ($posts as $post)
          <div class="col-lg-4">
            <div class="card">
                <div style="max-height: 400px">
                    <img src="{{ $post->image_url }}" class="card-img-top">
                </div>
                <div class="card-body">
                    <p>
                    <small class="text-muted">{{ $post->published_at }}</small>
                    </p>
                    <p class="card-text">{{ $post->title }}</p>
                    <a href="{{ $post->news_url }}" class="text-decoration-none" class="btn btn-primary">Read more..</a>
                </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <div class="d-flex justify-content-center mt-3">
      {{ $posts->links() }}
    </div>

@endsection