@extends('layout.admin', ['title' => 'Редактирование категории'])

@section('content')
    <h1>Просмотр категории</h1>
<div class="form-group">
        <p><h5>Наименование:</h5> {{ $category->name }}</p>
</div>
<div class="form-group">
    <p><h5>ЧПУ (на англ.)</h5>{{ $category->slug }}</p>
</div>
<div class="form-group">
    <h5>Родитель-категория</h5>
    @php
        $parent_id = old('parent_id') ?? $category->parent_id ?? 0;
    @endphp
    <select name="parent_id" class="form-control" title="Родитель">
        <option value="0">Без родителя</option>
        @include('admin.part.parents', ['level' => -1, 'parent' => 0])
    </select>
</div>
<div class="form-group">
    <p><h5>Краткое описание</h5>{{ $category->content }}</p>
</div>
<div class="form-group">
@isset($category->image)
    <img src="{{ asset($category->image) }}" width="170"/>
@endisset
</div>
@endsection
