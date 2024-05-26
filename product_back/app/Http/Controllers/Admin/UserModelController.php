<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Response;

class UserModelController extends Controller
{
    /**
     * Display a listing of the UserModel.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function index()
    {
        $userModels = UserModel::filter(Request::all(["search", ...UserModel::$searchIn]))->with('branch:id,name')
            ->orderBy(Request::input('orderBy') ?? 'id', Request::input('dir') ?? 'asc');

        if (Request::has('only')) {
            return json_encode($userModels->cursorPaginate(Request::input('per_page'), ['id', 'name']));
        }

        return Inertia::render('Admin/user_models/Index', [
            'filters' => Request::only(["search", ...UserModel::$searchIn, 'orderBy', 'dir']),
            'datas' => $userModels
                ->paginate(Request::input('per_page'))
                ->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new UserModel.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function create()
    {
        return Inertia::render('Admin/user_models/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created UserModel in storage.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store()
    {
        $rule = UserModel::$rules;
        $input =  Request::validate($rule);
        $input['password'] = Hash::make($input['password']);
        $userModel = UserModel::create($input);
        return redirect(Request::header('back') ?? route('admin.user_models.show', $userModel->getKey()))->with('success', 'Амжилттай үүсгэлээ.');
    }

    /**
     * Show the form for editing the specified UserModel.
     *
     * @param UserModel $userModel
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show(UserModel $userModel)
    {
        $userModel->load('branch:id,name');
        return Inertia::render('Admin/user_models/Show', [
            'data' =>  $userModel,
        ]);
    }

    /**
     * Show the form for editing the specified UserModel.
     *
     * @param UserModel $userModel
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function edit(UserModel $userModel)
    {
        $userModel->load('branch:id,name');
        return Inertia::render('Admin/user_models/Edit', [
            'data' =>  $userModel,
        ]);
    }

    /**
     * Update the specified UserModel in storage.
     *
     * @param UserModel $userModel
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update(UserModel $userModel)
    {
        $rule = UserModel::$rules;
        $input =  Request::validate($rule);
        $userModel->update($input);

        return redirect(Request::header('back') ?? route('admin.user_models.show', $userModel->getKey()))->with('success', 'Ажилттай хадгаллаа.');
    }

    /**
     * Remove the specified UserModel from storage.
     *
     * @param UserModel $userModel
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy(UserModel $userModel)
    {
        $userModel->delete();
        return redirect(Request::header('back') ?? route('admin.user_models.index'))->with('success', 'Мэдээлэл устгагдлаа.');
    }
}
