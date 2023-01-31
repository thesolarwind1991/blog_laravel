@if ($items->where('parent_id', $parent)->count())
    @php $level++ @endphp
    @foreach ($items->where('parent_id', $parent) as $item)

            <option value="{{$item->id}}" <?if ($item->id == $category_id) echo' selected ' ?>>
                @if ($level)
                    {{ str_repeat('—', $level) }}
                @endif
                @if($level)
                    <span>{{ $item->name }}</span>
                @else
                    <strong>{{ $item->name }}</strong>
                @endif
            </option>

        @include('admin.part.categories', ['level' => $level, 'parent' => $item->id, 'category_id' => $category_id])
    @endforeach
@endif
