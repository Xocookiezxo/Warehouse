<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Models\User;
use Hash;
use Illuminate\Validation\ValidationException;
use Response;

/**
 * Class UserController
 * @package App\Http\Controllers\API
 */

class UserAPIController extends AppBaseController
{
    /**
     * Store a newly created User in storage.
     * POST /usersModels
     *
     * @return Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'phone' => 'Нэвтрэх нэр нууц үг буруу, Эсвэл идэвхгүй байна',
            ]);
        }

        $user->token = $user->createToken('token')->plainTextToken;

        return  $user->toJson();
    }

    /**
     * Display a listing of the User.
     * GET|HEAD /users
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function index(Request $request)
    {
        $query = User::filter($request->all(["search", ...User::$searchIn]));

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $users = $query->get();

        return $users->toJson();
    }

    /**
     * Store a newly created User in storage.
     * POST /users
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store(Request $request)
    {
        $input = $request->validate([...User::$rules, "roles" => 'nullable']);
        $input['roles'] = "user";
        $input['password'] = Hash::make($request->password);
        /** @var User $user */
        $user = User::create($input);

        return $user->toJson();
    }

    /**
     * Display the specified User.
     * GET|HEAD /users/{id}
     *
     * @param User $users
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show($id)
    {
        /** @var User $user */
        $user = User::find($id);

        if (empty($user)) {
            return $this->sendError('User Model not found');
        }

        return $user->toJson();
    }

    /**
     * Update the specified User in storage.
     * PUT/PATCH /users/{id}
     *
     * @param User $users
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update($id, Request $request)
    {
        $input = $request->validate(User::$rules);
        /** @var User $user */
        $user = User::find($id);

        if (empty($user)) {
            return $this->sendError('User Model not found');
        }

        $user->fill($input);
        $user->save();

        return $user->toJson();
    }

    /**
     * Remove the specified User from storage.
     * DELETE /users/{id}
     *
     * @param User $users
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy($id)
    {
        /** @var User $user */
        $user = User::find($id);

        if (empty($user)) {
            return $this->sendError('User Model not found');
        }

        $user->delete();

        return $this->sendSuccess('User Model deleted successfully');
    }
}
