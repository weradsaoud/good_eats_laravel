<?php

namespace App\Http\Controllers;

use App\Models\Icategory;
use App\Http\Requests\StoreIcategoryRequest;
use App\Http\Requests\UpdateIcategoryRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Store;

class IcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $items_categories = Icategory::all();
            $response = [];
            foreach ($items_categories as $item_category) {
                $item_category_store = $item_category->store;
                $response_item = [
                    'store_id' => $item_category_store->id,
                    'store_name' => $item_category_store->name,
                    'item_category_id' => $item_category->id,
                    'item_category_name' => $item_category->name,
                    'active' => $item_category->active
                ];
                array_push($response, $response_item);
            }
            return response($response, 200);
        } catch (\Throwable $th) {
            return response(['error' => $th], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreIcategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIcategoryRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            foreach ($data as $store_id => $categories) {
                $store = Store::where('id', intval($store_id))->get()[0];
                foreach ($categories as $category) {
                    $tosave_category = new Icategory([
                        'name' => $category['cateName'],
                        'active' => $category['active']
                    ]);
                    $store->icatecories()->save($tosave_category);
                }
            }
            DB::commit();
            return response([
            ], 200);
        } catch (\Throwable $th) {
            return response(['notOK' => $th], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Icategory  $icategory
     * @return \Illuminate\Http\Response
     */
    public function show(Icategory $icategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateIcategoryRequest  $request
     * @param  \App\Models\Icategory  $icategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIcategoryRequest $request, Icategory $icategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Icategory  $icategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Icategory $icategory)
    {
        //
    }
}
