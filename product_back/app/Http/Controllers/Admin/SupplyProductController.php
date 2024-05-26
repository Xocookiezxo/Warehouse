<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupplyProduct;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Response;

class SupplyProductController extends Controller
{
    /**
     * Display a listing of the SupplyProduct.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function index()
    {
        $supplyProducts = SupplyProduct::filter(Request::all(["search", ...SupplyProduct::$searchIn]))->with('product:id,name')->with('supply:id,name')
            ->orderBy(Request::input('orderBy') ?? 'id', Request::input('dir') ?? 'asc');
        
        if (Request::has('only')) {
            return json_encode($supplyProducts->cursorPaginate(Request::input('per_page'),['id', 'name']));
        }

        return Inertia::render('Admin/supply_products/Index', [
            'filters' => Request::only(["search", ...SupplyProduct::$searchIn, 'orderBy', 'dir']),
            'datas' => $supplyProducts
                ->paginate(Request::input('per_page'))
                ->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new SupplyProduct.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function create()
    {
        return Inertia::render('Admin/supply_products/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created SupplyProduct in storage.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store()
    {
        $rule = SupplyProduct::$rules;
        $input =  Request::validate($rule);
        $supplyProduct = SupplyProduct::create($input);
        return redirect(Request::header('back') ?? route('admin.supply_products.show', $supplyProduct->getKey()))->with('success', 'Амжилттай үүсгэлээ.');
    }

    /**
     * Show the form for editing the specified UserModel.
     *
     * @param SupplyProduct $supplyProduct
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show(SupplyProduct $supplyProduct)
    {
        $supplyProduct->load('product:id,name')->load('supply:id,name');
        return Inertia::render('Admin/supply_products/Show', [
            'data' =>  $supplyProduct,
        ]);
    }

    /**
     * Show the form for editing the specified SupplyProduct.
     *
     * @param SupplyProduct $supplyProduct
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function edit(SupplyProduct $supplyProduct)
    {
        $supplyProduct->load('product:id,name')->load('supply:id,name');
        return Inertia::render('Admin/supply_products/Edit', [
            'data' =>  $supplyProduct,
        ]);
    }

    /**
     * Update the specified SupplyProduct in storage.
     *
     * @param SupplyProduct $supplyProduct
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update(SupplyProduct $supplyProduct)
    {
        $rule = SupplyProduct::$rules;
        $input =  Request::validate($rule);
        $supplyProduct->update($input);
        
        return redirect(Request::header('back') ?? route('admin.supply_products.show', $supplyProduct->getKey()))->with('success', 'Ажилттай хадгаллаа.');
    }

    /**
     * Remove the specified SupplyProduct from storage.
     *
     * @param SupplyProduct $supplyProduct
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy(SupplyProduct $supplyProduct)
    {
        $supplyProduct->delete();
        return redirect(Request::header('back') ?? route('admin.supply_products.index'))->with('success', 'Мэдээлэл устгагдлаа.');
    }
}
