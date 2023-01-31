<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    // TODO: нужна валидация загружаемого изображения

    /**
     * Загружает изображение, которое было добавлено в wysiwyg-редакторе и
     * возвращает ссылку на него, чтобы в редакторе вставить <img src="…"/>
     */
    public function upload(Request $request) {
        $path = $request->file('image')->store('upload', 'public');
        return Storage::disk('public')->url($path);
    }

    /**
     * Удаляет изображение, которое было удалено в wysiwyg-редакторе
     */
    public function remove(Request $request) {
        $path = parse_url($request->remove, PHP_URL_PATH);
        $path = str_replace('/storage/', '', $path);
        Storage::disk('public')->delete($path);
    }
}
