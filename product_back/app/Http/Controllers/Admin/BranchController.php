<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Response;

class BranchController extends Controller
{
    /**
     * Display a listing of the Branch.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function index()
    {
        $branches = Branch::filter(Request::all(["search", ...Branch::$searchIn]))
            ->orderBy(Request::input('orderBy') ?? 'id', Request::input('dir') ?? 'asc');
        
        if (Request::has('only')) {
            return json_encode($branches->cursorPaginate(Request::input('per_page'),['id', 'name']));
        }

        return Inertia::render('Admin/branches/Index', [
            'filters' => Request::only(["search", ...Branch::$searchIn, 'orderBy', 'dir']),
            'datas' => $branches
                ->paginate(Request::input('per_page'))
                ->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new Branch.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function create()
    {
        return Inertia::render('Admin/branches/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created Branch in storage.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store()
    {
        $rule = Branch::$rules;
        $input =  Request::validate($rule);
        $branch = Branch::create($input);
        return redirect(Request::header('back') ?? route('admin.branches.show', $branch->getKey()))->with('success', 'Амжилттай үүсгэлээ.');
    }

    /**
     * Show the form for editing the specified UserModel.
     *
     * @param Branch $branch
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show(Branch $branch)
    {
        $branch;
        return Inertia::render('Admin/branches/Show', [
            'data' =>  $branch,
        ]);
    }

    /**
     * Show the form for editing the specified Branch.
     *
     * @param Branch $branch
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function edit(Branch $branch)
    {
        $branch;
        return Inertia::render('Admin/branches/Edit', [
            'data' =>  $branch,
        ]);
    }

    /**
     * Update the specified Branch in storage.
     *
     * @param Branch $branch
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update(Branch $branch)
    {
        $rule = Branch::$rules;
        $input =  Request::validate($rule);
        $branch->update($input);
        
        return redirect(Request::header('back') ?? route('admin.branches.show', $branch->getKey()))->with('success', 'Ажилттай хадгаллаа.');
    }

    /**
     * Remove the specified Branch from storage.
     *
     * @param Branch $branch
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy(Branch $branch)
    {
        $branch->delete();
        return redirect(Request::header('back') ?? route('admin.branches.index'))->with('success', 'Мэдээлэл устгагдлаа.');
    }
}
