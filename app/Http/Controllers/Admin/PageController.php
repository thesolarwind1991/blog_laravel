<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct() {
        $this->middleware('perm:manage-pages')->only('index');
        $this->middleware('perm:create-page')->only(['create', 'store']);
        $this->middleware('perm:edit-page')->only(['edit', 'update']);
        $this->middleware('perm:delete-page')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     * Показывает список всех страниц
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$roots = Page::whereNull('parent_id')->with('children')->get();
        $roots = Page::with('children')->get();
        //dd($roots);
        return view('admin.page.index', compact('roots'));
    }

    /**
     * Show the form for creating a new resource.
     * Показывает форму для создания страницы
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parents = Page::whereNull('parent_id')->get();
        return view('admin.page.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     * Сохраняет новую страницу в базу данных
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'parent_id' => 'numeric|nullable',
            'slug' => 'required|max:100|unique:pages|regex:~^[-_a-z0-9]+$~i',
            'content' => 'required',
        ]);

        Page::create($request->all());
        //dd($request->all());
        return redirect()->route('admin.page.index')
            ->with('success', 'Новая страница была успешно создана!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * Показывает форму для редактирования страницы
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        $parents = Page::whereNull('parent_id')->where('id', '<>', $page->id)->get();
        return view('admin.page.edit', compact('page', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     * Обновляет страницу (запись в таблице БД)
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'parent_id' => 'numeric|not_in:'.$page->id.'|nullable',
            'slug' => 'required|max:100|unique:pages,slug,'.$page->id.',id|regex:~^[-_a-z0-9]+$~i',
            'content' => 'required',
            ]);
        $page->update($request->all());
        return redirect()
            ->route('admin.page.index')
            ->with('success', 'Страница была успешно отредактирована');
    }

    /**
     * Remove the specified resource from storage.
     * Удаляет страницу (запись в таблице БД)
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page, ImageUploader $imageUploader)
    {
        if ($page->children()->count()) {
            return back()->withErrors('Нельзя удалить страницу, у которой, есть дочерние');
        }
        $imageUploader->destroy($page->content);
        $page->delete();
        return redirect()
            ->route('admin.page.index')
            ->with('success', 'Страница сайта успешно удалена');
    }
}
