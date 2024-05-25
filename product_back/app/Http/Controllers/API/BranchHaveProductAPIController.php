<?php

namespace App\Http\Controllers\API;


use App\Models\BranchHaveProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class BranchHaveProductController
 * @package App\Http\Controllers\API
 */

class BranchHaveProductAPIController extends AppBaseController
{
    /**
     * Display a listing of the BranchHaveProduct.
     * GET|HEAD /branchHaveProducts
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function index(Request $request)
    {
        $query = BranchHaveProduct::filter( $request->all(["search", ...BranchHaveProduct::$searchIn]))->with('branch:id,name')->with('product:id,name')->with('user:id,name');

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $branchHaveProducts = $query->get();

        return $branchHaveProducts->toJson();
    }

    /**
     * Store a newly created BranchHaveProduct in storage.
     * POST /branchHaveProducts
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store(Request $request)
    {
        $input = $request->validate(BranchHaveProduct::$rules);

        /** @var BranchHaveProduct $branchHaveProduct */
        $branchHaveProduct = BranchHaveProduct::create($input);

        return $branchHaveProduct->toJson();
    }

    /**
     * Display the specified BranchHaveProduct.
     * GET|HEAD /branchHaveProducts/{id}
     *
     * @param BranchHaveProduct $branchHaveProducts
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show($id)
    {
        /** @var BranchHaveProduct $branchHaveProduct */
        $branchHaveProduct = BranchHaveProduct::find($id);

        if (empty($branchHaveProduct)) {
            return $this->sendError('Branch Have Product not found');
        }

        return $branchHaveProduct->toJson();
    }

    /**
     * Update the specified BranchHaveProduct in storage.
     * PUT/PATCH /branchHaveProducts/{id}
     *
     * @param BranchHaveProduct $branchHaveProducts
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update($id, Request $request)
    {
        $input = $request->validate(BranchHaveProduct::$rules);
        /** @var BranchHaveProduct $branchHaveProduct */
        $branchHaveProduct = BranchHaveProduct::find($id);

        if (empty($branchHaveProduct)) {
            return $this->sendError('Branch Have Product not found');
        }

        $branchHaveProduct->fill($input);
        $branchHaveProduct->save();

        return $branchHaveProduct->toJson();
    }

    /**
     * Remove the specified BranchHaveProduct from storage.
     * DELETE /branchHaveProducts/{id}
     *
     * @param BranchHaveProduct $branchHaveProducts
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy($id)
    {
        /** @var BranchHaveProduct $branchHaveProduct */
        $branchHaveProduct = BranchHaveProduct::find($id);

        if (empty($branchHaveProduct)) {
            return $this->sendError('Branch Have Product not found');
        }

        $branchHaveProduct->delete();

        return $this->sendSuccess('Branch Have Product deleted successfully');
    }
}
