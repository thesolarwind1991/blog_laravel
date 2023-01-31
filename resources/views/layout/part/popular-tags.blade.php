@if ($items->count())
    <div>
        <div class="fh5co_heading fh5co_heading_border_bottom py-2 mb-4">Популярные теги</div>
    </div>
    <div class="clearfix"></div>
    <div class="fh5co_tags_all">
    @foreach($items as $item)
        <a href="{{ route('blog.tag', ['tag' => $item->slug]) }}" class="fh5co_tagg">{{ $item->name }} ({{$item->posts_count }})</a>
    @endforeach
    </div>
    @endif
