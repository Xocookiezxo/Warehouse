<?php

namespace App\Http\Controllers\API;


use App\Models\SupplyProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class SupplyProductController
 * @package App\Http\Controllers\API
 */

class SupplyProductAPIController extends AppBaseController
{
    /**
     * Display a listing of the SupplyProduct.
     * GET|HEAD /supplyProducts
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function index(Request $request)
    {
        $query = SupplyProduct::filter( $request->all(["search", ...SupplyProduct::$searchIn]))->with('product:id,name')->with('supply:id,name');

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $supplyProducts = $query->get();

        return $supplyProducts->toJson();
    }

    /**
     * Store a newly created SupplyProduct in storage.
     * POST /supplyProducts
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store(Request $request)
    {
        $input = $request->validate(SupplyProduct::$rules);

        /** @var SupplyProduct $supplyProduct */
        $supplyProduct = SupplyProduct::create($input);

        return $supplyProduct->toJson();
    }

    /**
     * Display the specified SupplyProduct.
     * GET|HEAD /supplyProducts/{id}
     *
     * @param SupplyProduct $supplyProducts
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show($id)
    {
        /** @var SupplyProduct $supplyProduct */
        $supplyProduct = SupplyProduct::find($id);

        if (empty($supplyProduct)) {
            return $this->sendError('Supply Product not found');
        }

        return $supplyProduct->toJson();
    }

    /**
     * Update the specified SupplyProduct in storage.
     * PUT/PATCH /supplyProducts/{id}
     *
     * @param SupplyProduct $supplyProducts
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update($id, Request $request)
    {
        $input = $request->validate(SupplyProduct::$rules);
        /** @var SupplyProduct $supplyProduct */
        $supplyProduct = SupplyProduct::find($id);

        if (empty($supplyProduct)) {
            return $this->sendError('Supply Product not found');
        }

        $supplyProduct->fill($input);
        $supplyProduct->save();

        return $supplyProduct->toJson();
    }

    /**
     * Remove the specified SupplyProduct from storage.
     * DELETE /supplyProducts/{id}
     *
     * @param SupplyProduct $supplyProducts
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy($id)
    {
        /** @var SupplyProduct $supplyProduct */
        $supplyProduct = SupplyProduct::find($id);

        if (empty($supplyProduct)) {
            return $this->sendError('Supply Product not found');
        }

        $supplyProduct->delete();

        return $this->sendSuccess('Supply Product deleted successfully');
    }
}
