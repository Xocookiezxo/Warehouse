<?php

namespace App\Http\Controllers\API;


use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class BranchController
 * @package App\Http\Controllers\API
 */

class BranchAPIController extends AppBaseController
{
    /**
     * Display a listing of the Branch.
     * GET|HEAD /branches
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function index(Request $request)
    {
        $query = Branch::filter( $request->all(["search", ...Branch::$searchIn]));

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $branches = $query->get();

        return $branches->toJson();
    }

    /**
     * Store a newly created Branch in storage.
     * POST /branches
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store(Request $request)
    {
        $input = $request->validate(Branch::$rules);

        /** @var Branch $branch */
        $branch = Branch::create($input);

        return $branch->toJson();
    }

    /**
     * Display the specified Branch.
     * GET|HEAD /branches/{id}
     *
     * @param Branch $branches
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show($id)
    {
        /** @var Branch $branch */
        $branch = Branch::find($id);

        if (empty($branch)) {
            return $this->sendError('Branch not found');
        }

        return $branch->toJson();
    }

    /**
     * Update the specified Branch in storage.
     * PUT/PATCH /branches/{id}
     *
     * @param Branch $branches
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update($id, Request $request)
    {
        $input = $request->validate(Branch::$rules);
        /** @var Branch $branch */
        $branch = Branch::find($id);

        if (empty($branch)) {
            return $this->sendError('Branch not found');
        }

        $branch->fill($input);
        $branch->save();

        return $branch->toJson();
    }

    /**
     * Remove the specified Branch from storage.
     * DELETE /branches/{id}
     *
     * @param Branch $branches
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy($id)
    {
        /** @var Branch $branch */
        $branch = Branch::find($id);

        if (empty($branch)) {
            return $this->sendError('Branch not found');
        }

        $branch->delete();

        return $this->sendSuccess('Branch deleted successfully');
    }
}
