<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('perm:manage-users')->only('index');
        $this->middleware('perm:edit-user')->only(['edit', 'update']);
    }

    /**
     * Display a listing of the resource.
     * Показывает список всех пользователе
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(8);
        return view('admin.user.index', compact('users'));
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
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * Показывает форму для редактирования пользователя
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $allroles = Role::all();
        $allperms = Permission::all();

        return view('admin.user.edit',
             compact('user', 'allperms', 'allroles'));
    }

    /**
     * Update the specified resource in storage.
     * Обновляет данные пользователя в бд
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //Проверяем данные формы
        $this->validator($request->all(), $user->id)->validate();
        //Обновляем пользователя
        if ($request->change_password) {
            //если надо изменить пароль
            $request->merge(['password' => Hash::make($request->password)]);
            $user->update($request->all());
        } else {
            $user->update($request->except('password'));
        }

        /*
         * Назначаем роли и права
         */
        if (auth()->user()->hasPermAnyWay('assign-role')) {
            $user->roles()->sync($request->roles);
        }

        if (auth()->user()->hasPermAnyWay('assign-permission')) {
            $user->permissions()->sync($request->perms);
        }

        return redirect()
            ->route('admin.user.index')
            ->with('success', 'Данные пользователя успешно обновлены!');
    }

    private function validator(array $data, int $id) {
        $rules = [
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                // проверка на уникальность email, исключая
                // этого пользователя по идентифкатору
                'unique:users,email,'.$id.',id',
            ],
        ];
        if (isset($data['change_password'])) {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }
        return \Validator::make($data, $rules);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
