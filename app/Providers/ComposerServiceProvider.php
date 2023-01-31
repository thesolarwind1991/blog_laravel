<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Page;
use App\Models\Tag;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $views = [
            'layout.part.categories', //меню в правой колонке в публичной части
            'admin.part.categories', //выбор категории поста при редактировании
            'admin.part.parents', //выбор родителя категории при редактировании
            'admin.part.all-ctgs', //все категории в административной части
        ];
        View::composer($views,
            function($view) {
                static $items = null;
                if (is_null($items)) {
                    $items = Category::all();
                }
                $view->with(['items' => $items]);
            });

        View::composer('layout.part.popular-tags',
            function($view) {
                $view->with(['items' => Tag::popular()]);
            });
        View::composer('admin.part.all-tags', function($view) {
           $view->with(['items' => Tag::all()]);
        });

        View::composer('layout.part.all-pages', function($view) {
            $view->with(['pages' => Page::with('children')->get()]);
        });

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layout.part.categories',
           function($view)
           {
               static $items = null;

               if (is_null($items)) {
                   $items = Category::all();
                   $parent = 0;
                   $view->with(['items' => $items, 'parent' => $parent]);
               } else {
                   $view->with(['items' => $items]);
               }

           }
        );

        View::composer('layout.part.popular-tags', function($view) {
           $view->with(['items' => Tag::popular()]);
        });
    }
}
