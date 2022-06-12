<?php

namespace App\Http\Controllers;

use App\Models\hour;
use App\Http\Requests\StorehourRequest;
use App\Http\Requests\UpdatehourRequest;

class HourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorehourRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorehourRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\hour  $hour
     * @return \Illuminate\Http\Response
     */
    public function show(hour $hour)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatehourRequest  $request
     * @param  \App\Models\hour  $hour
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatehourRequest $request, hour $hour)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\hour  $hour
     * @return \Illuminate\Http\Response
     */
    public function destroy(hour $hour)
    {
        //
    }
}
