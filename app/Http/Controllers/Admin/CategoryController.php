<?php

namespace App\Http\Controllers\Admin;

use App\Classes\ImageSaver;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    private $imageSaver;

    public function __construct(ImageSaver $imageSaver) {
        $this->imageSaver = $imageSaver;
        $this->middleware('perm:manage-categories')->only('index');
        $this->middleware('perm:create-category')->only(['create', 'store']);
        $this->middleware('perm:edit-category')->only(['edit', 'update']);
        $this->middleware('perm:delete-category')->only('destroy');
    }


    /**
     * Display a listing of the resource.
     * Показывает список всех категорий
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Category::all();
        return view('admin.category.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     * Показывает форму создания категории
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     * Сохраняет новую категорию в базу данных
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category = new Category();
        $category->fill($request->except('image'));
        $category->image = $this->imageSaver->upload($category);
        $category->save();

        return redirect()
            ->route('admin.category.show', ['category' => $category->id])
            ->with('success', 'Новая категория успешно создана');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('admin.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     * Показывает форму для редактирования категории
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     * Обновляет категорию блога в базе данных
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $data = $request->except('image');
        $data['image'] = $this->imageSaver->upload($category);
        $category->update($data);
        return redirect()->route('admin.category.index')
            ->with('success', 'Категория была успешно отредактирована');
    }

    /**
     * Remove the specified resource from storage.
     * Удаляет категорию блога
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category->children()->count()) {
            $errors[] = 'Нельзя удалить категорию с дочерними категориями';
        }
        if ($category->posts->count()) {
            $errors[] = 'Нельзя удалить категорию, которая содержит посты';
        }
        if (!empty($errors)) {
            return back()->withErrors($errors);
        }

        // удаляем файл изображения
        $this->imageSaver->remove($category);

        //удаляем категорию блога
        $category->delete();
        return redirect()
            ->route('admin.category.index')
            ->with('success', 'Категория блога была успешно удалена');
    }
}
