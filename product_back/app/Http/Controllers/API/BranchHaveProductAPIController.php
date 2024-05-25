<?php

namespace App\Http\Controllers\API;


use App\Models\BranchHaveProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use DB;
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
        $query = BranchHaveProduct::filter($request->all(["search", ...BranchHaveProduct::$searchIn]))->with('branch:id,name')->with('product:id,name,price,barcode')->with('user:id,name');

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }
        $query->orderByDesc('created_at');
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

        $branch = $input['branch_id'];
        $product = $input['product_id'];

        if ($input['reg_type'] == "Зарлага") {
            $status_infos = DB::scalar(" select sum(r.pcount)   cnt
            from branche_have_products r
            inner join branches b on b.id = r.branch_id
            inner join products p on p.id= r.product_id
            where r.branch_id =$branch and p.id =$product
            group by p.barcode");
            if ($status_infos + $input['pcount'] < 0) {
                return $this->sendError("Агуулахын үлэгдэл хүрэхгүй байна. Агуулахад:$status_infos ", 422);
            }
        }

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
