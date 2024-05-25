<?php

namespace App\Http\Controllers\API;


use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ProductCategoryController
 * @package App\Http\Controllers\API
 */

class ProductCategoryAPIController extends AppBaseController
{
    /**
     * Display a listing of the ProductCategory.
     * GET|HEAD /productCategories
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function index(Request $request)
    {
        $query = ProductCategory::filter( $request->all(["search", ...ProductCategory::$searchIn]));

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $productCategories = $query->get();

        return $productCategories->toJson();
    }

    /**
     * Store a newly created ProductCategory in storage.
     * POST /productCategories
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store(Request $request)
    {
        $input = $request->validate(ProductCategory::$rules);

        /** @var ProductCategory $productCategory */
        $productCategory = ProductCategory::create($input);

        return $productCategory->toJson();
    }

    /**
     * Display the specified ProductCategory.
     * GET|HEAD /productCategories/{id}
     *
     * @param ProductCategory $productCategories
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show($id)
    {
        /** @var ProductCategory $productCategory */
        $productCategory = ProductCategory::find($id);

        if (empty($productCategory)) {
            return $this->sendError('Product Category not found');
        }

        return $productCategory->toJson();
    }

    /**
     * Update the specified ProductCategory in storage.
     * PUT/PATCH /productCategories/{id}
     *
     * @param ProductCategory $productCategories
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update($id, Request $request)
    {
        $input = $request->validate(ProductCategory::$rules);
        /** @var ProductCategory $productCategory */
        $productCategory = ProductCategory::find($id);

        if (empty($productCategory)) {
            return $this->sendError('Product Category not found');
        }

        $productCategory->fill($input);
        $productCategory->save();

        return $productCategory->toJson();
    }

    /**
     * Remove the specified ProductCategory from storage.
     * DELETE /productCategories/{id}
     *
     * @param ProductCategory $productCategories
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy($id)
    {
        /** @var ProductCategory $productCategory */
        $productCategory = ProductCategory::find($id);

        if (empty($productCategory)) {
            return $this->sendError('Product Category not found');
        }

        $productCategory->delete();

        return $this->sendSuccess('Product Category deleted successfully');
    }
}
