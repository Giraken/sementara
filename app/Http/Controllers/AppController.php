<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTenantRequest;
use App\Http\Requests\UpdateTenantRequest;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AppController extends Controller
{
    public function selectApp(Request $request)
    {
        return view('apps.select-app', []);
    }

    public function selectPlan(Request $request)
    {
        return view('apps.select-plan', []);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response()->view('apps.list', [
            'apps' => auth()->user()->apps,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('apps.create', []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTenantRequest $request
     * @return Response
     */
    public function store(StoreTenantRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param string $appID
     * @return Response
     */
    public function show($appID)
    {
        $app = Tenant::findOrFail($appID);

        return response()->view('apps.show', [
            'app' => $app,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Tenant $tenant
     * @return Response
     */
    public function edit(Tenant $tenant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTenantRequest $request
     * @param Tenant $tenant
     * @return Response
     */
    public function update(UpdateTenantRequest $request, Tenant $tenant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Tenant $tenant
     * @return Response
     */
    public function destroy(Tenant $tenant)
    {
        //
    }
}
