<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'published_by',
        'content',
    ];

    //Количество комментариев на странице при пагинации
    protected $perPage = 5;

    //Выбрать из БД только опубликованные комментарии
    public function scopePublished($builder) {
        return $builder->whereNotNull('published_by');
    }

    /*
     * Связь модели Comment с моделью Post, позволяет получить
     * родительский пост
     */
    public function posts()
    {
        return $this->belongsTo(Post::class, 'post_id');
        //return $this->hasOne(Post::class,'id');
    }

    /*
     * Связь модели Comment с моделью User, позволяет получить
     * автора комментария
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
     * Разрешить публикацию поста блога
     */
    public function enable() {
        $this->published_by = auth()->user()->id;
        $this->update();
    }

    /*
     * Запретить публикацию поста блога
     */
    public function disable() {
        $this->published_by = null;
        $this->update();
    }

    /*
     * Возвращает true, если публикация разрешена
     */
    public function isVisible() {
        return !is_null($this->published_by);
    }


    /*
     * Номер страницы пагинации, на которой расположен комментарий;
     * учитываются все комментарии, в том числе не опубликованные
     */
    public function adminPageNumber() {
        //$comments = $this->post->comments()->orderBy('created_at')->get();
        $comments = self::orderBy('created_at')->get();
        if ($comments->count() == 0) {
            return 1;
        }
        if ($comments->count() <= $this->getPerPage()) {
            return 1;
        }
        foreach ($comments as $i => $comment) {
            if ($this->id == $comment->id) {
                break;
            }
        }

        return (int) ceil(($i+1) / $this->getPerPage());

    }

    /**
     * Номер страницы пагинации, на которой расположен комментарий;
     * все опубликованные + не опубликованные этого пользователя
     */
    public function userPageNumber() {
        // все опубликованные комментарии других пользователей
        $others = $this->posts->comments()->published();
        // и не опубликованные комментарии этого пользователя
        $comments = $this->posts->comments()
            ->whereUserId(auth()->user()->id)
            ->whereNull('published_by')
            ->union($others)
            ->orderBy('created_at')
            ->get();
        if ($comments->count() == 0) {
            return 1;
        }
        if ($comments->count() <= $this->getPerPage()) {
            return 1;
        }
        foreach ($comments as $i => $comment) {
            if ($this->id == $comment->id) {
                break;
            }
        }
        return (int) ceil(($i+1) / $this->getPerPage());
    }

    /**
     * Возвращает true, если пользователь является автором
     */
    public function isAuthor() {
        return $this->user->id === auth()->user()->id;
    }

}
