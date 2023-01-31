<?php

use App\Http\Controllers\CKEditorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\User\IndexController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\IndexController as MainIndexController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\IndexController as AdminIndexController;
use App\Http\Controllers\User\PostController as UserPostController;
use App\Http\Controllers\User\CommentController as USerCommentController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return view('layout.site');
})->name('index');
*/

Route::get('/', MainIndexController::class)->name('index');

Route::get('page/{page:slug}', \App\Http\Controllers\PageController::class)->name('page');

// роуты регистрации, авторизации, восстановления пароля, верификации почты
Route::group([
    'as' => 'auth.', //имя маршрута, например auth.index
    'prefix' => 'auth', // префикс маршрута, например, auth/index
    ], function () {
        //форма регистрации
        Route::get('register', [RegisterController::class, 'register'])->name('register');

        //создание пользователя
        Route::post('register', [RegisterController::class, 'create'])->name('create');

        //форма входа авторизации
        Route::get('login', [LoginController::class, 'login'])->name('login');

        //аутентификация
        Route::post('login', [LoginController::class, 'authenticate'])->name('auth');

        //выход
        Route::get('logout', [LoginController::class, 'logout'])->name('logout');

        //форма ввода адреса почты
        Route::get('forgot-password', [ForgotPasswordController::class, 'form'])->name('forgot-form');

        //письмо на почту
        Route::post('forgot-password', [ForgotPasswordController::class, 'mail'])->name('forgot-mail');

        //форма восстановления пароля
        Route::get('reset-password/token/{token}/email/{email}',
                    [ResetPasswordController::class, 'form']
        )->name('reset-form');

        //восстановление пароля
        Route::post('reset-password',
                    [ResetPasswordController::class, 'reset']
        )->name('reset-password');

        //сообщение о необходимости проверки адреса почты
        Route::get('verify-message', [VerifyEmailController::class, 'message'])->name('verify-message');

        //подтверждение адреса почты нового пользователя
        Route::get('verify-email/token/{token}/id/{id}', [VerifyEmailController::class, 'verify'])
            ->where('token', '[a-f0-9]{32}')
            ->where('id', '[0-9]+')
            ->name('verify-email');
});

/*
 * Блог: все посты, посты категории, посты тега, страница поста
 */
Route::group([
    'as' => 'blog.', // имя маршрута, например blog.index
    'prefix' => 'blog', // префикс маршрута, например, blog/index
], function() {
   //главная страница (все посты)
   Route::get('index', [BlogController::class, 'index'])->name('index');

   //страница результатов поиска
    Route::get('search', [BlogController::class, 'search'])->name('search');

   //категория блога (посты категории)
   Route::get('category/{category:slug}', [BlogController::class, 'category'])->name('category');

   //тег блога (посты с этим тегом)
    Route::get('tag/{tag:slug}', [BlogController::class, 'tag'])->name('tag');

    // автор блога (посты этого автора)
    Route::get('author/{user}', [BlogController::class, 'author'])->name('author');

    //страница поста блога
    Route::get('post/{post:slug}', [BlogController::class, 'post'])->name('post');

    //добавление комментария к посту
    Route::post('post/{post}/comment', [BlogController::class, 'comment'])->name('comment');
});


// кабинет пользователя
Route::group([
        'as' => 'user.',
        'prefix' => 'user',
        //'namespace' => 'User',
        'middleware' => ['auth']
], function() {
        Route::get('index', [IndexController::class, 'index'])->name('index');

       /*
        * CRUD-операции над постами пользователя
        */
        Route::resource('post', UserPostController::class);

        /*
         * CRUD-операции над комментариями пользователя
         */
         Route::resource('comment', UserCommentController::class, ['except' => ['create', 'store']]);
});

// админка сайта
/*Route::group(['middleware' => 'role:admin'], function () {
   Route::get('/admin/index', function() {
       return "Это панель управления сайтом";
   })->name('admin.index');
});*/

Route::group([
    'as' => 'admin.', // имя маршрута, например admin.index
    'prefix' => 'admin', //префикс маршрута, например admin/index
    //'namespace' => 'Admin', // пространство имен контроллеров
    'middleware' => ['auth'] // один или несколько посредников
], function() {
    /*
     * Главная страница панели управления
     */
    Route::get('index', AdminIndexController::class)->name('index');

    /*
     * CRUD-операции над постами блога
     */
    Route::resource('post', PostController::class, ['except' => ['create', 'store']]);

    //дополнительный маршрут для показа постов категорий
    Route::get('post/category/{category}', [PostController::class, 'category'])
        ->name('post.category');

    //доп.маршрут, чтобы разрешить публикацию поста
    Route::get('post/enable/{post}', [PostController::class, 'enable'])
        ->name('post.enable');

    //доп.маршрут, чтобы запретить публикацию поста
    Route::get('post/disable/{post}', [PostController::class, 'disable'])
        ->name('post.disable');

    /*
     * CRUD-операции над категориями блога
     */
    Route::resource('category', CategoryController::class);

    /*
     * CRUD-операции над тегами блога
     */
    Route::resource('tag', TagController::class, ['except' => 'show']);

    /*
     * Просмотр и редактирование пользователей
     */
    Route::resource('user', UserController::class, ['except' => ['create', 'store', 'show', 'destroy']]);

    /*
     * CRUD-операции над комментариями
     */

    Route::resource('comment', CommentController::class, ['except' => ['create', 'store']]);

    //дополнительный маршрут, чтобы разрешить публикацию комментария
    Route::get('comment/enable/{comment}', [CommentController::class, 'enable'])->name('comment.enable');

    //доп.маршрут, чтобы запретить публикацию комментария
    Route::get('comment/disable/{comment}', [CommentController::class, 'disable'])->name('comment.disable');

    /*
     * CRUD-операции над ролями
     */
    Route::resource('role', RoleController::class, ['except' => 'show']);

    /*
     * CRUD-операции над страницами
    */
    Route::resource('page', PageController::class, ['except' => 'show']);
    //Route::get('admin/page2', [RoleController::class, 'index'])->name('page2.index');

    //загрузка изображения в редакторе
    Route::post('ckeditor/upload', [CKEditorController::class, 'upload'])->name('ckeditor.image-upload');
});
