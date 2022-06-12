<?php

namespace App\Http\Controllers;

use App\Models\Scategory;
use App\Http\Requests\StorescategoryRequest;
use App\Http\Requests\UpdatescategoryRequest;
use GuzzleHttp\Psr7\Request;

class ScategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $stores_categories = Scategory::all();
        return response($stores_categories, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorescategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorescategoryRequest $request)
    {
        //
        $fields = $request->validate([
            'name' => 'required|string|unique:scategories'
        ]);
        Scategory::Create([
            'name' => $fields['name']
        ]);
        return response([], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\scategory  $scategory
     * @return \Illuminate\Http\Response
     */
    public function show(scategory $scategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatescategoryRequest  $request
     * @param  \App\Models\scategory  $scategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatescategoryRequest $request)
    {
        //
        $fields = $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string'
        ]);

        try {
            $category = Scategory::findOrFail($fields['id']);
        } catch (\Throwable $th) {
            return response([], 404);
        }
        try {
            //code...
            $category->update(['name' => $fields['name']]);
            return response([], 200);
        } catch (\Throwable $th) {
            return response([], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\scategory  $scategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(StorescategoryRequest $request)
    {
        //
        $fields = $request->validate([
            'id' => 'required|integer'
        ]);
        try {
            $category = Scategory::findOrFail($fields['id']);
        } catch (\Throwable $th) {
            return response([], 404);
        }
        $category->delete();
        return response([], 200);
    }
}
