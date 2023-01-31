@extends('layout.site', ['title' => $post->name])

@section('content')
    <!--<div id="fh5co-title-box" style="background-image: url(images/camila-cordeiro-114636.jpg); background-position: 50% 90.5px;" data-stellar-background-ratio="0.5">
        -->
    <div>
        <div class="overlay"></div>
        <div class="page-title">
            <img style="width: 100%" src="{{ asset('images/camila-cordeiro-114636.jpg') }}" alt="{{ $post->name }}">
            <span>{{ $post->created_at }}</span>
            <h2>{{ $post->name }}</h2>
        </div>
    </div>

    <div class="col-md-8 animate-box" data-animate-effect="fadeInLeft">
        <p>
            {!! $post->content !!}
        </p>

        <div class="card-footer">
            Автор:
            <a href="{{ route('blog.author', ['user' => $post->user->id]) }}">
                {{ $post->user->name }}
            </a>
            <br>
            Дата: {{ $post->created_at }}
        </div>

        @if ($post->tags->count())
            <div class="card-footer">
                Теги:
                @foreach($post->tags as $tag)
                    @php $comma = $loop->last ? '' : ' • ' @endphp
                    <a href="{{ route('blog.tag', ['tag' => $tag->slug]) }}">
                        {{ $tag->name }}</a>
                    {{ $comma }}
                @endforeach
            </div>
        @endif

        @include('blog.part.comments', ['comments' => $comments])
    </div>
@endsection
