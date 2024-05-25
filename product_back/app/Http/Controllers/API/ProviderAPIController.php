<?php

namespace App\Http\Controllers\API;


use App\Models\Provider;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ProviderController
 * @package App\Http\Controllers\API
 */

class ProviderAPIController extends AppBaseController
{
    /**
     * Display a listing of the Provider.
     * GET|HEAD /providers
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function index(Request $request)
    {
        $query = Provider::filter( $request->all(["search", ...Provider::$searchIn]));

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $providers = $query->get();

        return $providers->toJson();
    }

    /**
     * Store a newly created Provider in storage.
     * POST /providers
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store(Request $request)
    {
        $input = $request->validate(Provider::$rules);

        /** @var Provider $provider */
        $provider = Provider::create($input);

        return $provider->toJson();
    }

    /**
     * Display the specified Provider.
     * GET|HEAD /providers/{id}
     *
     * @param Provider $providers
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show($id)
    {
        /** @var Provider $provider */
        $provider = Provider::find($id);

        if (empty($provider)) {
            return $this->sendError('Provider not found');
        }

        return $provider->toJson();
    }

    /**
     * Update the specified Provider in storage.
     * PUT/PATCH /providers/{id}
     *
     * @param Provider $providers
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update($id, Request $request)
    {
        $input = $request->validate(Provider::$rules);
        /** @var Provider $provider */
        $provider = Provider::find($id);

        if (empty($provider)) {
            return $this->sendError('Provider not found');
        }

        $provider->fill($input);
        $provider->save();

        return $provider->toJson();
    }

    /**
     * Remove the specified Provider from storage.
     * DELETE /providers/{id}
     *
     * @param Provider $providers
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy($id)
    {
        /** @var Provider $provider */
        $provider = Provider::find($id);

        if (empty($provider)) {
            return $this->sendError('Provider not found');
        }

        $provider->delete();

        return $this->sendSuccess('Provider deleted successfully');
    }
}
