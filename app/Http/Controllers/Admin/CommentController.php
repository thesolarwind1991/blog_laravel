<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Post;

class CommentController extends Controller
{
    public function __construct() {
        $this->middleware('perm:manage-comments')->only(['index', 'show']);
        $this->middleware('perm:edit-comment')->only('update');
        $this->middleware('perm:publish-comment')->only(['enable', 'disable']);
        $this->middleware('perm:delete-comment')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     * Показывает список всех комментариев
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::orderBy('created_at', 'desc')->paginate();
        return view('admin.comment.index', compact('comments'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     * Просмотр комментария к посту блога
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //Сигнализирует о том, что это режим предпросмотра
        session()->flash('preview', 'yes');
        /*$id = $comment->post_id;
        $posts = Post::where('id', $id)->get();
        $comments = Comment::where('post_id', $id)->OrderBy('created_at', 'desc')->paginate();
        */
        $posts = $comment->posts;
        //dd($comments);
        $comments = $posts->comments()->orderBy('created_at', 'desc')->paginate();
        //используем шаблон предварительного просмотра поста
        return view('admin.comment.show', compact('posts', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     * Показывает форму редактирования комментария
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //нужно сохранить flash-переменную, которая сигнализирует о том,
        // что конпока редактирования была нажата в режиме предпросмотра
        session()->keep('preview');
        return view('admin.comment..edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     * Обновляет комментари в базе данных
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $comment->update($request->all());
        return $this->redirectAfterUpdate($comment);
    }

    /*
     * Разрешить публикацию комментария
     */
    public function enable(Comment $comment) {
        $comment->enable();
        $redirect = back();
        if (session('preview')) {
            $redirect = $redirect->withFragment('comment-list');
        }
        return $redirect->with('success', 'Комментарий был опубликован');
    }

    /*
     * Запретить публикацию комментария
     */
    public function disable(Comment $comment) {
        $comment->disable();
        $redirect = back();
        if (session('preview')) {
            $redirect = $redirect->withFragment('comment-list');
        }
        return $redirect->with('success', 'Комментарий снят с публикации');
    }

    /**
     * Remove the specified resource from storage.
     * Удаляет комментарий из базы данных
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        $redirect = back();
        if (session('preview')) {
            $redirect = $redirect->withFragment('comment-list');
        }
        return $redirect->with('success', 'Комментарий был успешно удален');
    }

    /*
     * Выполняет редирект после обновления
     */
    private function redirectAfterUpdate(Comment $comment) {
        // Кнопка редактирования может быть нажата в режиме предпросмотра
        // или в панели управления блогом, потому и редирект будет разным
        $redirect = redirect();
        if (session('preview')) {
            $redirect = $redirect->route(
                'admin.comment.show',
            ['comment' => $comment->id, 'page' => 1]
            )->withFragment('comment-list');
        } else {
            $redirect = $redirect->route('admin.comment.index');
        }
        return $redirect->with('success', 'Комментарий был успешно отредактирован');
    }
}
