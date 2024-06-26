<?php

namespace App\Http\Controllers\API;


use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use DB;
use Response;

/**
 * Class ProductController
 * @package App\Http\Controllers\API
 */

class ProductAPIController extends AppBaseController
{
    /**
     * Display a listing of the Product.
     * GET|HEAD /products
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function index(Request $request)
    {
        $query = Product::filter($request->all(["search", ...Product::$searchIn]))->with('product_category:id,name')->with('provider:id,name');

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }
        $query->orderByDesc("created_at");
        $products = $query->get();

        return $products->toJson();
    }
    public function uldegdel(Request $request, $branch_id)
    {


        $where = " WHERE 1=1 ";
        if ($branch_id)
            $where .= "  AND   r.branch_id = '" . $branch_id . "' ";


        $status_infos = DB::select(" select 
                                    p.id,b.name branch_name,p.name product_name,p.barcode,p.price,sum(r.pcount)   cnt
                                    from branche_have_products r
                                    inner join branches b on b.id = r.branch_id
                                    inner join products p on p.id= r.product_id
                        $where
                        group by  p.id, b.name,p.name,p.price,p.barcode");



        return $status_infos;
    }
    /**
     * Store a newly created Product in storage.
     * POST /products
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store(Request $request)
    {
        $input = $request->validate(Product::$rules);

        /** @var Product $product */
        $product = Product::create($input);

        return $product->toJson();
    }

    /**
     * Display the specified Product.
     * GET|HEAD /products/{id}
     *
     * @param Product $products
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show($id)
    {
        /** @var Product $product */
        $product = Product::find($id);

        if (empty($product)) {
            return $this->sendError('Product not found');
        }

        return $product->toJson();
    }

    /**
     * Update the specified Product in storage.
     * PUT/PATCH /products/{id}
     *
     * @param Product $products
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update($id, Request $request)
    {
        $input = $request->validate(Product::$rules);
        /** @var Product $product */
        $product = Product::find($id);

        if (empty($product)) {
            return $this->sendError('Product not found');
        }

        $product->fill($input);
        $product->save();

        return $product->toJson();
    }

    /**
     * Remove the specified Product from storage.
     * DELETE /products/{id}
     *
     * @param Product $products
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy($id)
    {
        /** @var Product $product */
        $product = Product::find($id);

        if (empty($product)) {
            return $this->sendError('Product not found');
        }

        $product->delete();

        return $this->sendSuccess('Product deleted successfully');
    }
}
