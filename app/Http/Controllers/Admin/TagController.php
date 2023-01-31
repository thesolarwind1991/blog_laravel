<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function __construct() {
        $this->middleware('perm:manage-tags')->only('index');
        $this->middleware('perm:create-tag')->only(['create', 'store']);
        $this->middleware('perm:edit-tag')->only(['edit', 'update']);
        $this->middleware('perm:delete-tag')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     * Показывает список всех тегов блога
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Tag::paginate(10);
        //dd($items);
        return view('admin.tag.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     * Показывает форму для создания тега
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tag.create');
    }

    /**
     * Store a newly created resource in storage.
     * Сохраняет новый тег в базу данных
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $t = $this->validator($request->all(), null)->validate();
        //dd($t);
        $tag = Tag::create($request->all());
        return redirect()
            ->route('admin.tag.index')
            ->with('success', 'Новый тег блога успешно создан');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * Показывает форму для редактирования тега
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return view('admin.tag.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     * Обновляет тег блога в базе данных
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        $this->validator($request->all(), $tag->id)->validate();
        $tag->update($request->all());
        return redirect()
            ->route('admin.tag.index')
            ->with('success', 'Тег блога был успешно отредактирован');
    }

    /**
     * Remove the specified resource from storage.
     * Удаляет тег блога из базы данных
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()
            ->route('admin.tag.index')
            ->with('success', 'Тег блога был успешно удален');
    }

    /*
     * Возвращает объект валидатора с нужными правилами
     */
    public function validator($data, $id) {
        $unique = 'unique:tags,slug';
        if ($id) {
            // проверка на уникальность slug тега при редактировании,
            // исключая этот тег по идентификатору в таблице БД tags
            $unique = 'unique:tags,slug,'.$id.',id';
        }

        $rules = [
            'name' => [
                'required',
                'string',
                'max:50',
            ],
            'slug' => [
                'required',
                'max:50',
                $unique,
                'regex:~^[-_a-z0-9]+$~i',
            ]
        ];

        $messages = [
                'required' => 'Поле «:attribute» обязательно для заполнения',
                'max' => 'Поле «:attribute» должно быть не больше :max символов',
            ];
        $attributes = [
            'name' => 'Наименование',
            'slug' => 'ЧПУ (англ.)'
        ];

        return \Validator::make($data, $rules, $messages, $attributes);

    }
}
