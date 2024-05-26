<?php

namespace App\Http\Controllers\API;


use App\Models\Supply;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Models\BranchHaveProduct;
use Response;

/**
 * Class SupplyController
 * @package App\Http\Controllers\API
 */

class SupplyAPIController extends AppBaseController
{
    /**
     * Display a listing of the Supply.
     * GET|HEAD /supplies
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function index(Request $request)
    {
        $query = Supply::filter($request->all(["search", ...Supply::$searchIn]))->with('supplyProducts.product')->where('status', '<>', 'done');

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $supplies = $query->get();

        return $supplies->toJson();
    }

    /**
     * Store a newly created Supply in storage.
     * POST /supplies
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store(Request $request)
    {
        $input = $request->validate(Supply::$rules);

        /** @var Supply $supply */
        $supply = Supply::create($input);

        return $supply->toJson();
    }

    /**
     * Display the specified Supply.
     * GET|HEAD /supplies/{id}
     *
     * @param Supply $supplies
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show($id)
    {
        /** @var Supply $supply */
        $supply = Supply::find($id);

        if (empty($supply)) {
            return $this->sendError('Supply not found');
        }

        return $supply->toJson();
    }

    /**
     * Update the specified Supply in storage.
     * PUT/PATCH /supplies/{id}
     *
     * @param Supply $supplies
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update($id, Request $request)
    {
        $input = $request->validate(Supply::$rules);
        /** @var Supply $supply */
        $supply = Supply::find($id);

        if (empty($supply)) {
            return $this->sendError('Supply not found');
        }

        $supply->fill($input);
        $supply->save();

        return $supply->toJson();
    }

    public function done($id, Request $request)
    {
        $input = $request->validate(Supply::$rules);
        /** @var Supply $supply */
        $supply = Supply::find($id);
        $supply->status = 'done';

        foreach ($supply->supplyProducts as $key => $value) {
            if ($value->pcount > 0) {
                BranchHaveProduct::create([
                    'branch_id' =>  1,
                    'product_id' =>  $value->product_id,
                    'pcount' =>  $value->pcount,
                    'user_id' => $request->user()->id,
                    'reg_type' => "Oрлого",
                ]);
            }
        }

        $supply->save();

        return $supply->toJson();
    }

    /**
     * Remove the specified Supply from storage.
     * DELETE /supplies/{id}
     *
     * @param Supply $supplies
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy($id)
    {
        /** @var Supply $supply */
        $supply = Supply::find($id);

        if (empty($supply)) {
            return $this->sendError('Supply not found');
        }

        $supply->delete();

        return $this->sendSuccess('Supply deleted successfully');
    }
}
