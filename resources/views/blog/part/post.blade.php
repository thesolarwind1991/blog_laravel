<div class="row pb-4">
    <div class="col-md-5">
        <div class="fh5co_hover_news_img">
            <div class="fh5co_news_img">
                <img src="{{ asset('images/nathan-mcbride-229637.jpg') }}" alt=""/></div>
            <div></div>
        </div>
    </div>
    <div class="col-md-7 animate-box">
        <a href="{{ route('blog.post', ['post' => $post->slug]) }}" class="fh5co_magna py-2">{{ $post->name }}</a>
          <a href="{{ route('blog.author', ['user' => $post->user->id]) }}" class="fh5co_mini_time py-3">
              {{ $post->user->name }} -
              {{ $post->created_at }}
          </a>
        <div class="fh5co_consectetur">
        {{ $post->excerpt }}
        </div>
        @if ($post->tags->count())
                Теги:
                <div class="fh5co_tags_all">
                @foreach($post->tags as $tag)
                    @php $point = $loop->last ? '' : ' • ' @endphp
                <a href="{{ route('blog.tag', ['tag' => $tag->slug]) }}">{{$tag->name}}</a>
                    {{ $point }}
                @endforeach
                </div>

        @endif
    </div>
</div>
