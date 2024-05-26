<?php

namespace App\Http\Controllers\API;


use App\Models\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class UserModelController
 * @package App\Http\Controllers\API
 */

class UserModelAPIController extends AppBaseController
{
    /**
     * Display a listing of the UserModel.
     * GET|HEAD /userModels
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function index(Request $request)
    {
        $query = UserModel::filter( $request->all(["search", ...UserModel::$searchIn]))->with('branch:id,name');

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $userModels = $query->get();

        return $userModels->toJson();
    }

    /**
     * Store a newly created UserModel in storage.
     * POST /userModels
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store(Request $request)
    {
        $input = $request->validate(UserModel::$rules);

        /** @var UserModel $userModel */
        $userModel = UserModel::create($input);

        return $userModel->toJson();
    }

    /**
     * Display the specified UserModel.
     * GET|HEAD /userModels/{id}
     *
     * @param UserModel $userModels
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show($id)
    {
        /** @var UserModel $userModel */
        $userModel = UserModel::find($id);

        if (empty($userModel)) {
            return $this->sendError('User Model not found');
        }

        return $userModel->toJson();
    }

    /**
     * Update the specified UserModel in storage.
     * PUT/PATCH /userModels/{id}
     *
     * @param UserModel $userModels
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update($id, Request $request)
    {
        $input = $request->validate(UserModel::$rules);
        /** @var UserModel $userModel */
        $userModel = UserModel::find($id);

        if (empty($userModel)) {
            return $this->sendError('User Model not found');
        }

        $userModel->fill($input);
        $userModel->save();

        return $userModel->toJson();
    }

    /**
     * Remove the specified UserModel from storage.
     * DELETE /userModels/{id}
     *
     * @param UserModel $userModels
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy($id)
    {
        /** @var UserModel $userModel */
        $userModel = UserModel::find($id);

        if (empty($userModel)) {
            return $this->sendError('User Model not found');
        }

        $userModel->delete();

        return $this->sendSuccess('User Model deleted successfully');
    }
}
