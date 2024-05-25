<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Response;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the ProductCategory.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function index()
    {
        $productCategories = ProductCategory::filter(Request::all(["search", ...ProductCategory::$searchIn]))
            ->orderBy(Request::input('orderBy') ?? 'id', Request::input('dir') ?? 'asc');
        
        if (Request::has('only')) {
            return json_encode($productCategories->cursorPaginate(Request::input('per_page'),['id', 'name']));
        }

        return Inertia::render('Admin/product_categories/Index', [
            'filters' => Request::only(["search", ...ProductCategory::$searchIn, 'orderBy', 'dir']),
            'datas' => $productCategories
                ->paginate(Request::input('per_page'))
                ->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new ProductCategory.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function create()
    {
        return Inertia::render('Admin/product_categories/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created ProductCategory in storage.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store()
    {
        $rule = ProductCategory::$rules;
        $input =  Request::validate($rule);
        $productCategory = ProductCategory::create($input);
        return redirect(Request::header('back') ?? route('admin.product_categories.show', $productCategory->getKey()))->with('success', 'Амжилттай үүсгэлээ.');
    }

    /**
     * Show the form for editing the specified UserModel.
     *
     * @param ProductCategory $productCategory
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show(ProductCategory $productCategory)
    {
        $productCategory;
        return Inertia::render('Admin/product_categories/Show', [
            'data' =>  $productCategory,
        ]);
    }

    /**
     * Show the form for editing the specified ProductCategory.
     *
     * @param ProductCategory $productCategory
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function edit(ProductCategory $productCategory)
    {
        $productCategory;
        return Inertia::render('Admin/product_categories/Edit', [
            'data' =>  $productCategory,
        ]);
    }

    /**
     * Update the specified ProductCategory in storage.
     *
     * @param ProductCategory $productCategory
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update(ProductCategory $productCategory)
    {
        $rule = ProductCategory::$rules;
        $input =  Request::validate($rule);
        $productCategory->update($input);
        
        return redirect(Request::header('back') ?? route('admin.product_categories.show', $productCategory->getKey()))->with('success', 'Ажилттай хадгаллаа.');
    }

    /**
     * Remove the specified ProductCategory from storage.
     *
     * @param ProductCategory $productCategory
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy(ProductCategory $productCategory)
    {
        $productCategory->delete();
        return redirect(Request::header('back') ?? route('admin.product_categories.index'))->with('success', 'Мэдээлэл устгагдлаа.');
    }
}
