<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BranchHaveProduct;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Response;

class BranchHaveProductController extends Controller
{
    /**
     * Display a listing of the BranchHaveProduct.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function index()
    {
        $branchHaveProducts = BranchHaveProduct::filter(Request::all(["search", ...BranchHaveProduct::$searchIn]))->with('branch:id,name')->with('product:id,name')->with('user:id,name')
            ->orderBy(Request::input('orderBy') ?? 'id', Request::input('dir') ?? 'asc');
        
        if (Request::has('only')) {
            return json_encode($branchHaveProducts->cursorPaginate(Request::input('per_page'),['id', 'name']));
        }

        return Inertia::render('Admin/branch_have_products/Index', [
            'filters' => Request::only(["search", ...BranchHaveProduct::$searchIn, 'orderBy', 'dir']),
            'datas' => $branchHaveProducts
                ->paginate(Request::input('per_page'))
                ->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new BranchHaveProduct.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function create()
    {
        return Inertia::render('Admin/branch_have_products/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created BranchHaveProduct in storage.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store()
    {
        $rule = BranchHaveProduct::$rules;
        $input =  Request::validate($rule);
        $branchHaveProduct = BranchHaveProduct::create($input);
        return redirect(Request::header('back') ?? route('admin.branch_have_products.show', $branchHaveProduct->getKey()))->with('success', 'Амжилттай үүсгэлээ.');
    }

    /**
     * Show the form for editing the specified UserModel.
     *
     * @param BranchHaveProduct $branchHaveProduct
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show(BranchHaveProduct $branchHaveProduct)
    {
        $branchHaveProduct->load('branch:id,name')->load('product:id,name')->load('user:id,name');
        return Inertia::render('Admin/branch_have_products/Show', [
            'data' =>  $branchHaveProduct,
        ]);
    }

    /**
     * Show the form for editing the specified BranchHaveProduct.
     *
     * @param BranchHaveProduct $branchHaveProduct
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function edit(BranchHaveProduct $branchHaveProduct)
    {
        $branchHaveProduct->load('branch:id,name')->load('product:id,name')->load('user:id,name');
        return Inertia::render('Admin/branch_have_products/Edit', [
            'data' =>  $branchHaveProduct,
        ]);
    }

    /**
     * Update the specified BranchHaveProduct in storage.
     *
     * @param BranchHaveProduct $branchHaveProduct
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update(BranchHaveProduct $branchHaveProduct)
    {
        $rule = BranchHaveProduct::$rules;
        $input =  Request::validate($rule);
        $branchHaveProduct->update($input);
        
        return redirect(Request::header('back') ?? route('admin.branch_have_products.show', $branchHaveProduct->getKey()))->with('success', 'Ажилттай хадгаллаа.');
    }

    /**
     * Remove the specified BranchHaveProduct from storage.
     *
     * @param BranchHaveProduct $branchHaveProduct
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy(BranchHaveProduct $branchHaveProduct)
    {
        $branchHaveProduct->delete();
        return redirect(Request::header('back') ?? route('admin.branch_have_products.index'))->with('success', 'Мэдээлэл устгагдлаа.');
    }
}
