@extends('layout.site', ['title' => 'Блоги'])

@section('content')
    <div>
        <div class="fh5co_heading fh5co_heading_border_bottom py-2 mb-4">Блоги</div>
    </div>
    <div class="row pb-4">
    @foreach($posts as $post)
        @include('blog.part.post', ['post' => $post])
    @endforeach
    </div>
    {{ $posts -> links() }}
@endsection
