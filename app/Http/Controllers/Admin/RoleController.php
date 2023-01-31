<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function __construct() {
        $this->middleware('perm:manage-roles')->only('index');
        $this->middleware('perm:create-role')->only(['create', 'store']);
        $this->middleware('perm:edit-role')->only(['edit', 'update']);
        $this->middleware('perm:delete-role')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     * Показывает список всех ролей пользователя
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::paginate(8);
        return view('admin.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     * Показывает форму для создания роли
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allperms = Permission::all();
        return view('admin.role.create', compact('allperms'));
    }

    /**
     * Store a newly created resource in storage.
     * Сохраняет новую роль в базу данных
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $this->validator($request->all(), null)->validate();
       $role = Role::create($request->all());
       $role->permissions()->attach($request->perms ?? []);
       return redirect()->route('admin.role.index')
           ->with('success', 'Новая роль успешно создана');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * Показывает форму для редактирования роли
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $allperms = Permission::all();
        return view('admin.role.edit', compact('role', 'allperms'));
    }

    /**
     * Update the specified resource in storage.
     * Обновляет роль в базе данных
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        if ($role->id === 1) {
            return redirect()
                ->route('admin.role.index')
                ->withErrors('Эту роль нельзя редактировать');
        }

        $this->validator($request->all(), $role->id)->validate();
        $role->update($request->all());
        $role->permissions()->sync($request->perms ?? []);
        return redirect()
            ->route('admin.role.index')
            ->with('success', 'Роль была успешно отредактирована!');

    }

    /**
     * Remove the specified resource from storage.
     * Удаляет роль из базы данных
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if ($role->id === 1) {
            return redirect()
                ->route('admin.role.index')
                ->withErrors('Эту роль нельзя удалить');
        }
    }

    /*
     * Возвращает объект валидатора с нужными правилами
     */
    private function validator($data, $id){
        $unique = 'unique:roles,slug';
        if ($id) {
            // проверка на уникальность slug роли при редактировании,
            // исключая эту роль по идентифкатору в таблице БД roles
            $unique = 'unique:roles,slug,'.$id.',id';
        }
        $rules = [
            'name' => [
                'required',
                'string',
                'max:50',
            ],
            'slug' => [
                'required',
                'max:50',
                $unique,
                'regex:~^[-_a-z0-9]+$~i',
            ]
        ];
        $messages = [
            'required' => 'Поле «:attribute» обязательно для заполнения',
            'max' => 'Поле «:attribute» должно быть не больше :max символов',
        ];
        $attributes = [
            'name' => 'Наименование',
            'slug' => 'Идентификатор'
        ];
        return Validator::make($data, $rules, $messages, $attributes);
    }
}
