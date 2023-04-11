<?php

namespace Romkamix\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Romkamix\App\Http\Requests\HostStoreRequest;
use Romkamix\App\Http\Requests\HostUpdateRequest;
use Romkamix\App\Http\Resources\HostCollection;
use Romkamix\App\Http\Resources\HostResource;
use Romkamix\App\Models\Host;

class HostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new HostCollection(Host::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HostStoreRequest $request)
    {
        $validated = $request->validated();

        $validated['user_id'] = Auth::user()->id;

        $host = Host::create($validated);

        return new HostResource($host);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HostUpdateRequest $request, Host $host)
    {
        $validated = $request->validated();

        $host->update($validated);

        return new HostResource($host);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
