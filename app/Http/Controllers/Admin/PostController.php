<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Classes\ImageSaver;

class PostController extends Controller
{
    private $imageSaver;

    public function __construct(ImageSaver $imageSaver) {
        $this->imageSaver = $imageSaver;

        $this->middleware('perm:manage-posts')->only(['index', 'category', 'show']);
        $this->middleware('perm:edit-post')->only(['edit', 'update']);
        $this->middleware('perm:publish-post')->only(['enable', 'disable']);
        $this->middleware('perm:delete-post')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     * Список всех постов блога
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roots = Category::where('parent_id', 0)->get();
        $posts = Post::orderBy('created_at', 'desc')->paginate();
        return view('admin.post.index', compact('roots', 'posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /*
     * Список постов категории блога
     */
    public function category(Category $category) {
        $posts = $category->posts()->paginate();
        return view('admin.post.category', compact('category', 'posts'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     * Страница посмотра поста блога
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //сигнализирует о том, что это режим пред.просмотра
        session()->flash('preview', 'yes');
        return view('admin.post.show', compact('post'));
    }

    /*
     * Разрешить публикацию поста блога
     */
    public function enable(Post $post) {
        $post->enable();
        return back()->with('success', 'Пост блога был опубликован');
    }

    /*
     * Запретить публикацию поста блога
     */
    public function disable(Post $post) {
        $post->disable();
        return back()->with('success', 'Пост блога снят с публикации');
    }

    /**
     * Show the form for editing the specified resource.
     * Показывает форму редактирования пста
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //нужно сохранить flash-переменную, которая сигнализирует о том,
        //что конпока редактирования была нажата в режиме пред.просмотра
        session()->keep('preview');
        return view('admin.post.edit', compact('post'));

    }

    /**
     * Update the specified resource in storage.
     * Обновляет пост блога в базе данных
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        $data = $request->except(['image', 'tags']);
        $data['image'] = $this->imageSaver->upload($post);

        $post->update($data);
        $post->tags()->sync($request->tags);
        //кнопка редактирования может быть нажата в режиме пред.просмотра
        //или в панели управления блогом, так что и редирект будет разным
        $route = 'admin.post.index';
        $param = [];
        if (session('preview')) {
            $route = 'admin.post.show';
            $param = ['post' => $post->id];
        }
        return redirect()
            ->route($route, $param)
            ->with('success', 'Пост был успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     * Удаляет пост блога из базы данных
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->imageSaver->remove($post);
        $post->delete();
        //пост может быть удален в режиме пред.просмотра или из панели
        //управления, так что и редирект после удаления будет разным
        $route = 'admin.post.index';
        if (session('preview')) {
            $route = 'blog.index';
        }
        return redirect()
            ->route($route)
            ->with('success', 'Пост блога успешно удален');
    }
}
