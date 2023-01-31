<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * Возвращает массив правил для проверки полей формы
     * @return array<string, mixed>
     */
    public function rules()
    {
        $unique = 'unique:posts,slug';
        if (in_array($this->route()->getName(), ['admin.post.update', 'user.post.update'])) {
            // получаем модель Post через маршрут admin/post/{post}
            $model = $this->route('post');
            /*
             * Проверка на уникальность slug, исключая этот пост по идентификатору:
             * 1. posts - таблица базы данных, где проверяется уникальность
             * 2. slug - имя колонки, уникальность значения которой проверяется
             * 3. значение по которому из проверки исключается запись таблицы БД
             * 4. поле, по которому из проверки исключается запись таблицы БД
             * Для проверки будет использован такой SQL-запрос к базе данных:
             * SELECT COUNT(*) FROM `posts` WHERE `slug` = '...' AND `id` <> 17
             */
            $unique = 'unique:posts,slug,'.$model->id.',id';
        }

        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],
            'slug' => [
                'required',
                'max:100',
                $unique,
                'regex:~^[-_a-z0-9]+$~i',
            ],
            'category_id' => [
                'required',
                'integer',
                'min:1'
            ],
            'excerpt' => [
                'required',
                'min:100',
                'max:500',
            ],
            'content' => [
                'required',
                'min:500',
            ],
            'image' => [
                'mimes:jpeg,jpg,png',
                'max:5000'
            ],
        ];
    }

    public function messages() {
        return [

            'min' => [
                'string' => 'Поле «:attribute» должно быть не меньше :min символов',
                'integer' => 'Поле «:attribute» должно быть :min или больше',
                'file' => 'Файл «:attribute» должен быть не меньше :min Кбайт'
            ],

        ];
    }
}
