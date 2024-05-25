<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the Product.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function index()
    {
        $products = Product::filter(Request::all(["search", ...Product::$searchIn]))->with('product_category:id,name')->with('provider:id,name')
            ->orderBy(Request::input('orderBy') ?? 'id', Request::input('dir') ?? 'asc');
        
        if (Request::has('only')) {
            return json_encode($products->cursorPaginate(Request::input('per_page'),['id', 'name']));
        }

        return Inertia::render('Admin/products/Index', [
            'filters' => Request::only(["search", ...Product::$searchIn, 'orderBy', 'dir']),
            'datas' => $products
                ->paginate(Request::input('per_page'))
                ->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new Product.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function create()
    {
        return Inertia::render('Admin/products/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created Product in storage.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store()
    {
        $rule = Product::$rules;
        $input =  Request::validate($rule);
        $product = Product::create($input);
        return redirect(Request::header('back') ?? route('admin.products.show', $product->getKey()))->with('success', 'Амжилттай үүсгэлээ.');
    }

    /**
     * Show the form for editing the specified UserModel.
     *
     * @param Product $product
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show(Product $product)
    {
        $product->load('product_category:id,name')->load('provider:id,name');
        return Inertia::render('Admin/products/Show', [
            'data' =>  $product,
        ]);
    }

    /**
     * Show the form for editing the specified Product.
     *
     * @param Product $product
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function edit(Product $product)
    {
        $product->load('product_category:id,name')->load('provider:id,name');
        return Inertia::render('Admin/products/Edit', [
            'data' =>  $product,
        ]);
    }

    /**
     * Update the specified Product in storage.
     *
     * @param Product $product
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update(Product $product)
    {
        $rule = Product::$rules;
        $input =  Request::validate($rule);
        $product->update($input);
        
        return redirect(Request::header('back') ?? route('admin.products.show', $product->getKey()))->with('success', 'Ажилттай хадгаллаа.');
    }

    /**
     * Remove the specified Product from storage.
     *
     * @param Product $product
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect(Request::header('back') ?? route('admin.products.index'))->with('success', 'Мэдээлэл устгагдлаа.');
    }
}
