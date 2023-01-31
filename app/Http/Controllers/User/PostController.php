<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Classes\ImageSaver;

class PostController extends Controller
{
    private $imageSaver;
    public function __construct(ImageSaver $imageSaver) {
        $this->imageSaver = $imageSaver;
        $this->middleware('perm:create-post')->only(['create', 'store']);
    }

    /**
     * Display a listing of the resource.
     * Список всех постов пользователя
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::whereUserId(auth()->user()->id)->orderByDesc('created_at')->paginate();
        return view('user.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     * Показывает форму создания поста
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.post.create');
    }

    /**
     * Store a newly created resource in storage.
     * Сохраняет новый пост в базу данных
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $request->merge(['user_id' => auth()->user()->id]);
        //$post = Post::create($request->all());
        //сохраняем новый пост в базе данных
        $post = new Post();
        $post->fill($request->except(['image', 'tags']));
        $post->image = $this->imageSaver->upload($post);
        $post->save();
        // привязываем теги к новому посту
        $post->tags()->attach($request->tags);
        return redirect()->route('user.post.show', ['post' => $post->id])
        ->with('success', 'Новы пост успешно создан');
    }

    /**
     * Display the specified resource.
     * Страница предпросмотра поста блога
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        // можно просматривать только свои посты
        if (!$post->isAuthor()) {
            abourt(404);
        }
        // сигнализирует о том, что это режим предпросмотра
        session()->flash('preview', 'yes');
        //все опубликованные комментарии других пользователей
        $others = $post->comments()->published();
        // и не опубликованные комментарии других пользователей
        $comments = $post->comments()
            ->whereUserId(auth()->user()->id)
            ->whereNull('published_by')
            ->union($others)
            ->orderBy('created_at')
            ->paginate();

        return view('user.post.show', compact('post', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     * Показывает форму редактирования поста
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //редактировать можно только свои посты
        If (! $post->isAuthor()) {
            abort(404);
        }

        // редактировать можно не опубликованные
        if ($post->isVisible()) {
            about(404);
        }

        //нужно сохранить flash-переменную, которая сигнализирует о том,
        // что кнопка редактирования была нажата в режиме предпросмотра.
        session()->keep('preview');
        return view('user.post.edit', compact('post'));
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
        // обновлять можно только свои посты
        if (! $post->isAuthor()) {
            abort(404);
        }

        // обновлять можно не опубликованные
        if ($post->isVisible()) {
            abourt(404);
        }

        if (!$this->can($post)) {
            abort(404);
        }

        $data = $request->except(['image', 'tags']);
        $data['image'] = $this->imageSaver->upload($post);

        $post->update($data);
        $post->tags()->sync($request->tags);
        // кнопка редактирования может быть нажата в режиме предпросмотра
        // или в личном кабинете пользователя, поэтому редирект разный
        $route = 'user.post.index';
        $param = [];
        if (session('preview')) {
            $route = 'user.post.show';
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
        // удалять можно только свои посты
        if (! $post->isAuthor()) {
            abort(404);
        }

        // удалять можно не опубликованные
        if ($post->isVisible()) {
            abort(404);
        }

        if (!$this->can($post)) {
            about(404);
        }

        //удаляем изображение поста
        $this->imageSaver->remove($post);
        $post->delete();
        return redirect()
            ->route('user.post.index')
            ->with('success', 'Пост блога успешно удален');
    }
}
