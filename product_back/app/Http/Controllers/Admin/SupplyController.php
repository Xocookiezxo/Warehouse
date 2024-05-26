<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supply;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Response;

class SupplyController extends Controller
{
    /**
     * Display a listing of the Supply.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function index()
    {
        $supplies = Supply::filter(Request::all(["search", ...Supply::$searchIn]))
            ->orderBy(Request::input('orderBy') ?? 'id', Request::input('dir') ?? 'asc');

        if (Request::has('only')) {
            return json_encode($supplies->cursorPaginate(Request::input('per_page'), ['id', 'name']));
        }

        return Inertia::render('Admin/supplies/Index', [
            'filters' => Request::only(["search", ...Supply::$searchIn, 'orderBy', 'dir']),
            'datas' => $supplies
                ->paginate(Request::input('per_page'))
                ->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new Supply.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function create()
    {
        return Inertia::render('Admin/supplies/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created Supply in storage.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store()
    {
        $rule = Supply::$rules;
        $input =  Request::validate($rule);
        $input['status'] = "in progress";
        $supply = Supply::create($input);
        return redirect(Request::header('back') ?? route('admin.supplies.show', $supply->getKey()))->with('success', 'Амжилттай үүсгэлээ.');
    }

    /**
     * Show the form for editing the specified UserModel.
     *
     * @param Supply $supply
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show(Supply $supply)
    {
        $supply;
        return Inertia::render('Admin/supplies/Show', [
            'data' =>  $supply,
        ]);
    }

    /**
     * Show the form for editing the specified Supply.
     *
     * @param Supply $supply
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function edit(Supply $supply)
    {
        $supply;
        return Inertia::render('Admin/supplies/Edit', [
            'data' =>  $supply,
        ]);
    }

    /**
     * Update the specified Supply in storage.
     *
     * @param Supply $supply
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update(Supply $supply)
    {
        $rule = Supply::$rules;
        $input =  Request::validate($rule);
        $supply->update($input);

        return redirect(Request::header('back') ?? route('admin.supplies.show', $supply->getKey()))->with('success', 'Ажилттай хадгаллаа.');
    }

    /**
     * Remove the specified Supply from storage.
     *
     * @param Supply $supply
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy(Supply $supply)
    {
        $supply->delete();
        return redirect(Request::header('back') ?? route('admin.supplies.index'))->with('success', 'Мэдээлэл устгагдлаа.');
    }
}
