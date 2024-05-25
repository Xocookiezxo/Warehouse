<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Response;

class ProviderController extends Controller
{
    /**
     * Display a listing of the Provider.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function index()
    {
        $providers = Provider::filter(Request::all(["search", ...Provider::$searchIn]))
            ->orderBy(Request::input('orderBy') ?? 'id', Request::input('dir') ?? 'asc');
        
        if (Request::has('only')) {
            return json_encode($providers->cursorPaginate(Request::input('per_page'),['id', 'name']));
        }

        return Inertia::render('Admin/providers/Index', [
            'filters' => Request::only(["search", ...Provider::$searchIn, 'orderBy', 'dir']),
            'datas' => $providers
                ->paginate(Request::input('per_page'))
                ->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new Provider.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function create()
    {
        return Inertia::render('Admin/providers/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created Provider in storage.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store()
    {
        $rule = Provider::$rules;
        $input =  Request::validate($rule);
        $provider = Provider::create($input);
        return redirect(Request::header('back') ?? route('admin.providers.show', $provider->getKey()))->with('success', 'Амжилттай үүсгэлээ.');
    }

    /**
     * Show the form for editing the specified UserModel.
     *
     * @param Provider $provider
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show(Provider $provider)
    {
        $provider;
        return Inertia::render('Admin/providers/Show', [
            'data' =>  $provider,
        ]);
    }

    /**
     * Show the form for editing the specified Provider.
     *
     * @param Provider $provider
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function edit(Provider $provider)
    {
        $provider;
        return Inertia::render('Admin/providers/Edit', [
            'data' =>  $provider,
        ]);
    }

    /**
     * Update the specified Provider in storage.
     *
     * @param Provider $provider
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update(Provider $provider)
    {
        $rule = Provider::$rules;
        $input =  Request::validate($rule);
        $provider->update($input);
        
        return redirect(Request::header('back') ?? route('admin.providers.show', $provider->getKey()))->with('success', 'Ажилттай хадгаллаа.');
    }

    /**
     * Remove the specified Provider from storage.
     *
     * @param Provider $provider
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy(Provider $provider)
    {
        $provider->delete();
        return redirect(Request::header('back') ?? route('admin.providers.index'))->with('success', 'Мэдээлэл устгагдлаа.');
    }
}
