<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     * Список всех комментариев пользователя
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::whereUserId(auth()->user()->id)
            ->orderByDesc('created_at')
            ->paginate();
        return view('user.comment.index', compact('comments'));
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
        //можно просматривать только свои комментарии
        If (! $comment->isAuthor()) {
            abort(404);
        }

        //сигнализирует о том, что это режим предпросмотра
        session()->flash('preview', 'yes');
        //это тот пост блога, к которому оставлен комментарий
        $post = $comment->posts;
        //все опубликованные комментарии других пользователей
        $others = $post->comments()->published();
        // и не опубликованные комментарии этого пользователя
        $comments = $post->comments()
            ->whereUserId(auth()->user()->id)
            ->whereNull('published_by')
            ->union($others)
            ->orderBy('created_at')
            ->paginate();

        //используем шаблон предварительного просмотра
        return view('user.post.show', compact('post', 'comments'));

    }

    /**
     * Show the form for editing the specified resource.
     * Показывает форму редактирования комментария
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //проверяем права пользователя на это действие
        if (!$this->can($comment)) {
            abort(404);
        }

        // нужжно сохранить flash-переменную, которая сигнализирует о том,
        // что кнопка редактирования была нажата в режиме предпросмотра
        session()->keep('preview');
        return view('user.comment.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     * Обновляет комментарий в базе данных
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(CommentRequest $request, Comment $comment)
    {
        //проверяем права пользователя на это действие
        if (! $this->can($comment)) {
            abort(404);
        }
        $comment->update($request->all());
        return $this->redirectAfterUpdate($comment);
    }

    /**
     * Remove the specified resource from storage.
     * Удаляет комментарий из базы данных
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //проверяем права пользователя на это действие
        if (!$this->can($comment)) {
            abort(404);
        }

        $comment->delete();
        //Кнопка удаления может быть нажата в режиме предпросмотра
        // или в личном кабинете пользователя, потому редирект разный
        $redirect = back();
        if (session('preview')) {
            $redirect = $redirect->withFragment('comment-list');
        }
        return $redirect->with('success', 'Комментарий успешно удален');

    }

    /*
     * Выполняет редирект после обновления
     */
    private function redirectAfterUpdate(Comment $comment) {
        // кнопка редактирования может быть нажата в режиме пред.просмотра
        // или в личном кабинете пользователя, поэтому и редирект разный
        $redirect = redirect();
        if (session('preview')) {
            $redirect = $redirect->route(
                'user.comment.show',
                ['comment' => $comment->id, 'page' => $comment->userPageNumber()]
            )->withFragment('comment-list');
        } else {
            $redirect = $redirect->route('user.comment.index');
        }
        return $redirect->with('success', 'Комментарий был успешно исправлен');
    }

    /**
     * Проверяет, что пользователь может редактировать
     * или удалять пост блога
     */
    private function can(Comment $comment) {
        return $comment->isAuthor() && !$comment->isVisible();
    }
}
