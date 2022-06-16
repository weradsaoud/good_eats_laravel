<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\UpdateStoreRequest;
use App\Models\Extra;
use App\Models\Hour;
use App\Models\Icategory;
use App\Models\Item;
use App\Models\Option;
use App\Models\Scategory;
use App\Models\Variant;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = Store::all();
        $response = [];
        foreach ($stores as $key => $store) {
            $response_element = [];
            $store_cover_path = 'storage/' . str_replace("public/", "", $store['cover']); //str_replace("world","Peter","Hello world!");
            $store_logo_path = 'storage/' . str_replace("public/", "", $store['logo']);
            $store_cover_link = asset($store_cover_path);
            $store_logo_link = asset($store_logo_path);
            //get scate
            $store_category = $store->scategories[0];
            $store_cate_id = $store_category->id;
            $store_cate_name = $store_category->name;
            $store_hours = $store->hour;
            $response_element['store_cate_id'] = $store_cate_id;
            $response_element['store_cate_name'] = $store_cate_name;
            $response_element['store_owner_id'] = 1; // todo
            $response_element['store_owner_name'] = 'owner'; //todo
            $response_element['active'] = $store['active'];
            $response_element['adress'] = $store['adress'];
            $response_element['can_deliver'] = $store['can_deliver'];
            $response_element['can_pickup'] = $store['can_pickup'];
            $response_element['can_table_order'] = $store['can_table_order'];
            $response_element['cover'] = $store_cover_link;
            $response_element['deliver_minimum_spend'] = $store['deliver_minimum_spend'];
            $response_element['description'] = $store['description'];
            $response_element['email'] = $store['email'];
            $response_element['id'] = $store['id'];
            $response_element['logo'] = $store_logo_link;
            $response_element['name'] = $store['name'];
            $response_element['phone'] = $store['phone'];
            $response_element['pickup_minimum_spend'] = $store['pickup_minimum_spend'];
            $response_element['table_oredr_minimum_spend'] = $store['table_oredr_minimum_spend'];
            $response_element['sat_from'] = $store_hours->sat_from;
            $response_element['sat_to'] = $store_hours->sat_to;
            $response_element['sun_from'] = $store_hours->sun_from;
            $response_element['sun_to'] = $store_hours->sun_to;
            $response_element['mon_from'] = $store_hours->mon_from;
            $response_element['mon_to'] = $store_hours->mon_to;
            $response_element['tue_from'] = $store_hours->tue_from;
            $response_element['tue_to'] = $store_hours->tue_to;
            $response_element['wed_from'] = $store_hours->wed_from;
            $response_element['wed_to'] = $store_hours->wed_to;
            $response_element['thur_from'] = $store_hours->thur_from;
            $response_element['thur_to'] = $store_hours->thur_to;
            $response_element['fri_from'] = $store_hours->fri_from;
            $response_element['fri_to'] = $store_hours->fri_to;

            array_push($response, $response_element);
        }
        return response($response, 200);
    }

    public function index_client()
    {
        $stores = Store::all();
        $response = [];
        foreach ($stores as $key => $store) {
            $response_element = [];
            $orderingTypes = [];
            if ($store['can_deliver']) {
                array_push($orderingTypes, 'Delivery');
            }
            if ($store['can_pickup']) {
                array_push($orderingTypes, 'Pickup');
            }
            if ($store['can_table_order']) {
                array_push($orderingTypes, 'Table ordering');
            }
            $store_cover_path = 'storage/' . str_replace("public/", "", $store['cover']); //str_replace("world","Peter","Hello world!");
            $store_logo_path = 'storage/' . str_replace("public/", "", $store['logo']);
            $store_cover_link = asset($store_cover_path);
            $store_logo_link = asset($store_logo_path);
            $response_element['id'] = $store['id'];
            $response_element['name'] = $store['name'];
            $response_element['description'] = $store['description'];
            $response_element['orderingTypes'] = $orderingTypes;
            $response_element['logo'] = $store_logo_link;
            $response_element['cover'] = $store_cover_link;
            $response_element['opened'] = true;
            $response_element['maxServeTime'] = 30;

            array_push($response, $response_element);
        }
        return response($response, 200);
    }

    public function store_categories_client(Request $request)
    {
        try {
            $store_id = $request->storeId;
            $store = Store::where('id', $store_id)->get()[0];
            $store_categories = $store->icatecories;
            $response = [];
            foreach ($store_categories as $cate) {
                $cate_items = $cate->items;
                $response_item['cate_id'] =  $cate->id;
                $response_item['cate_name'] = $cate->name;
                $response_item['cate_description'] = 'this category contains delicious items, and it is made from natural incrediants.';
                $items = [];
                foreach ($cate_items as $cate_item) {
                    $item['item_id'] =  $cate_item->id;
                    $item['cate_id'] = $cate->id;
                    $item['item_name'] = $cate_item->name;
                    $item['item_description'] = $cate_item->description;
                    $item['item_price'] = $cate_item->price;
                    $item_img_path = 'storage/' . str_replace("public/", "", $cate_item->image);
                    $item_img_link = asset($item_img_path);
                    $item['item_img'] = $item_img_link;
                    array_push($items, $item);
                }
                $response_item['items'] = $items;
                array_push($response, $response_item);
            }
            return response($response, 200);
        } catch (\Throwable $th) {
            return response($th, 500);
        }
    }

    public function item_options_client(Request $request)
    {
        try {

            $item_id = $request->item_id;
            $item = Item::where('id', $item_id)->get()[0];
            $options = $item->options;
            $response = [];
            foreach ($options as $option) {
                $response_item['optionId'] = $option->id;
                $response_item['name'] = $option->name;
                $options_json = json_decode($option->options, true);
                $response_item['values'] = [];
                foreach ($options_json as $value) {
                    array_push($response_item['values'], $value);
                }
                array_push($response, $response_item);
            }
            return response($response, 200);
        } catch (\Throwable $th) {
            return response($th, 500);
        }
    }

    public function item_extras_client(Request $request)
    {
        try {
            $item_id = $request->item_id;
            $item = Item::where('id', $item_id)->get()[0];
            $item_extras = $item->extras;
            $response = [];
            foreach ($item_extras as $extra) {
                $response_item = [];
                $response_item['extraId'] = $extra->id;
                $response_item['name'] = $extra->name;
                $response_item['price'] = $extra->price;
                array_push($response, $response_item);
            }
            return response($response, 200);
        } catch (\Throwable $th) {
            return response($th, 500);
        }
    }

    public function variant_extras_client(Request $request)
    {
        $item_id = $request->item_id;
        $variant = $request->variant;
        $item = Item::where('id', $item_id)->get()[0];
        $item_variants = $item->variants;
        $target_variants = $item_variants->filter(function ($item_variant, $key) use ($variant) {
            return $item_variant->options == $variant;
        });
        $target_variant = null;
        if ($target_variants->count() > 0) {
            $target_variant = $target_variants->first();
            $extras = $target_variant->extras;
            $response = [];
            foreach ($extras as $extra) {
                $response_item = [];
                $response_item['extraId'] = $extra->id;
                $response_item['name'] = $extra->name;
                $response_item['price'] = $extra->price;
                array_push($response, $response_item);
            }
            return response($response, 200);
        } else {
            return response([], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $store_info_str = $request->storeInfo;
            $store_info = json_decode($store_info_str, true);
            $store_photos_dir = 'public/photos/' . $store_info['name'];
            $coverphoto_path = $request->file('storeCoverPhoto')->store($store_photos_dir);
            $logophoto_path = $request->file('storeLogoPhoto')->store($store_photos_dir);
            //
            $store = new Store(
                [
                    'name' => $store_info['name'],
                    'email' => $store_info['email'],
                    'phone' => $store_info['phone'],
                    'adress' => 'good_eats', //$store_info['adress'],
                    'cover' => $coverphoto_path,
                    'logo' => $logophoto_path,
                    'active' => $store_info['active'],
                    'description' => $store_info['description'],
                    'can_deliver' => $store_info['canDeliver'],
                    'deliver_minimum_spend' => floatval($store_info['deliveryMinSpend']),
                    'can_pickup' => $store_info['canPickup'],
                    'pickup_minimum_spend' => floatval($store_info['pickupMinSpend']),
                    'can_table_order' => $store_info['canTableOrder'],
                    'table_oredr_minimum_spend' => floatval($store_info['tableOrderMinSpend'])
                ]
            );
            $store->save();
            $saved_store = Store::where('id', $store->id)->get()[0];
            $store_category = Scategory::where('id', intval($store_info['categoryId']))->get()[0];
            $saved_store->scategories()->attach($store_category->id);
            //
            $store_hours = new Hour([
                'sat_from' => $store_info['saterday'] ? $store_info['satFrom'] : null,
                'sat_to' => $store_info['saterday'] ? $store_info['satTo'] : null,
                'sun_from' => $store_info['sunday'] ? $store_info['sunFrom'] : null,
                'sun_to' => $store_info['sunday'] ? $store_info['sunTo'] : null,
                'mon_from' => $store_info['monday'] ? $store_info['monFrom'] : null,
                'mon_to' => $store_info['monday'] ? $store_info['monTo'] : null,
                'tue_from' => $store_info['tuesday'] ? $store_info['tueFrom'] : null,
                'tue_to' => $store_info['tuesday'] ? $store_info['tueTo'] : null,
                'wed_from' => $store_info['wednesday'] ? $store_info['wedFrom'] : null,
                'wed_to' => $store_info['wednesday'] ? $store_info['wedTo'] : null,
                'thur_from' => $store_info['thursday'] ? $store_info['thurFrom'] : null,
                'thur_to' => $store_info['thursday'] ? $store_info['thurTo'] : null,
                'fri_from' => $store_info['friday'] ? $store_info['friFrom'] : null,
                'fri_to' => $store_info['friday'] ? $store_info['friTo'] : null,
            ]);
            $saved_store->hour()->save($store_hours);
            //
            $items_categories_str = $request->itemsCategories;
            $items_str = $request->items;
            $options_str = $request->options;
            $extras_str = $request->extras;
            $variants_str = $request->variants;

            $items_categories_arr = json_decode($items_categories_str, true);
            $items_arr = json_decode($items_str, true);
            $options_arr = json_decode($options_str, true);
            $extras_arr = json_decode($extras_str, true);
            $variants_arr = json_decode($variants_str, true);

            $items_categories =  []; // for store->savemany
            $items =  []; // for store->savemany
            $options =  []; // for store->savemany
            $extras =  []; // for store->savemany
            $variants = [];
            foreach ($items_categories_arr as $cate_id => $i_cate) {
                $cate = new Icategory([
                    'name' => $i_cate['name'],
                    'active' => $i_cate['active']
                ]);
                //array_push($items_categories, $cate);// save to database

                $saved_store->icatecories()->save($cate);
                $saved_cate = Icategory::where('id', $cate->id)->get()[0];
                //arrange items
                $cate_items = array_filter($items_arr, function ($item) use ($cate_id) {
                    return $item['itemCategoryId'] == (string)$cate_id;
                });
                foreach ($cate_items as $item_id => $cate_item) {
                    $item_photo_path = $request->file($cate_item['name'] . '_' . $cate_item['id'])->store($store_photos_dir);
                    $item = new Item([
                        'name' => $cate_item['name'],
                        'description' => $cate_item['description'],
                        'image' => $item_photo_path,
                        'price' => floatval($cate_item['price']),
                        'available' => $cate_item['active'],
                        'vat' => floatval($cate_item['vatValue'])
                    ]);
                    //array_push($items, $item);
                    $saved_store->items()->save($item);
                    $saved_item = Item::where('id', $item->id)->get()[0];
                    $saved_cate->items()->attach($saved_item->id);
                    //$saved_item = Item::where('id', $item->id);
                    //arrange options
                    $item_options = $options_arr[$item_id];
                    foreach ($item_options as $item_option) {
                        $option_values = [];
                        $index = 1;
                        foreach ($item_option['values'] as $val) {
                            $option_values[$index] = $val;
                            $index++;
                        }
                        $option_values_json = json_encode($option_values);
                        $option = new Option([
                            'name' => $item_option['name'],
                            'options' => $option_values_json
                        ]);
                        //array_push($item_options, $option);
                        $saved_item->options()->save($option);
                    }
                    //arrange extras
                    $item_extras = $extras_arr[$item_id];
                    foreach ($item_extras as $item_extra) {
                        $extra = new Extra([
                            'name' => $item_extra['name'],
                            'price' => floatval($item_extra['price'])
                        ]);
                        $saved_item->extras()->save($extra);
                    }
                    //arrange variants
                    $item_variants = $variants_arr[$item_id];
                    foreach ($item_variants as $item_variant) {
                        $variant_options_arr = [];
                        foreach ($item_variant as $key => $value) {
                            if (($key != 'price') && ($key != 'extras'))
                                $variant_options_arr[$key] = $value;
                        }
                        $variant_options_json = json_encode($variant_options_arr);
                        $variant = new Variant([
                            'options' => $variant_options_json,
                            'price' => $item_variant['price']
                        ]);
                        $saved_item->variants()->save($variant);
                        $saved_variant = Variant::where('id', $variant->id)->get()[0];
                        $variant_extras = $item_variant['extras'];
                        foreach ($variant_extras as $extra_id) {
                            $extra_name_arr = [];
                            $extra_name_arr = array_values(array_filter($item_extras, function ($extra) use ($extra_id) {
                                return $extra['id'] == (string)$extra_id;
                            }));
                            $extra_name = $extra_name_arr[0]['name'];
                            $saved_extra = Extra::where('name', $extra_name)->where('item_id', $saved_item->id)->get()[0];
                            $saved_variant->extras()->attach($saved_extra->id);
                        }
                    }
                }
            }
            DB::commit();
            return response(['store_id' => $store->id], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response(['notok' => json_encode($th)], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $fields = $request->validate([
            'id' => 'required|integer'
        ]);
        try {
            $store = Store::findOrFail($fields['id']);

            $store_cover_path = 'storage/' . str_replace("public/", "", $store['cover']); //str_replace("world","Peter","Hello world!");
            $store_logo_path = 'storage/' . str_replace("public/", "", $store['logo']);
            $store_cover_link = asset($store_cover_path);
            $store_logo_link = asset($store_logo_path);
            //get scate
            $store_category = $store->scategories[0];
            $store_cate_id = $store_category->id;
            $store_cate_name = $store_category->name;
            $store_hours = $store->hour;
            $response['store_cate_id'] = $store_cate_id;
            $response['store_cate_name'] = $store_cate_name;
            $response['store_owner_id'] = 1; // todo
            $response['store_owner_name'] = 'owner'; //todo
            $response['active'] = $store['active'];
            $response['adress'] = $store['adress'];
            $response['can_deliver'] = $store['can_deliver'];
            $response['can_pickup'] = $store['can_pickup'];
            $response['can_table_order'] = $store['can_table_order'];
            $response['cover'] = $store_cover_link;
            $response['deliver_minimum_spend'] = $store['deliver_minimum_spend'];
            $response['description'] = $store['description'];
            $response['email'] = $store['email'];
            $response['id'] = $store['id'];
            $response['logo'] = $store_logo_link;
            $response['name'] = $store['name'];
            $response['phone'] = $store['phone'];
            $response['pickup_minimum_spend'] = $store['pickup_minimum_spend'];
            $response['table_oredr_minimum_spend'] = $store['table_oredr_minimum_spend'];
            $response['sat_from'] = $store_hours->sat_from;
            $response['sat_to'] = $store_hours->sat_to;
            $response['sun_from'] = $store_hours->sun_from;
            $response['sun_to'] = $store_hours->sun_to;
            $response['mon_from'] = $store_hours->mon_from;
            $response['mon_to'] = $store_hours->mon_to;
            $response['tue_from'] = $store_hours->tue_from;
            $response['tue_to'] = $store_hours->tue_to;
            $response['wed_from'] = $store_hours->wed_from;
            $response['wed_to'] = $store_hours->wed_to;
            $response['thur_from'] = $store_hours->thur_from;
            $response['thur_to'] = $store_hours->thur_to;
            $response['fri_from'] = $store_hours->fri_from;
            $response['fri_to'] = $store_hours->fri_to;
            return response($response, 200);
        } catch (\Throwable $th) {
            return response($th, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStoreRequest  $request
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $toEdit_store_id = intval($request->storeId);
            $toEdit_store = Store::where('id', $toEdit_store_id)->get()[0];
            $store_info_str = $request->storeInfo;
            $store_info = json_decode($store_info_str, true);
            $store_photos_dir = 'public/photos/' . $store_info['name'];
            if ($request->hasFile('storeCoverPhoto')) {
                //todo delete old storeCoverPhoto
                $coverphoto_path = $request->file('storeCoverPhoto')->store($store_photos_dir);
            } else {
                $coverphoto_path = $toEdit_store->cover;
            }
            if ($request->hasFile('storeLogoPhoto')) {
                //todo delete old storeLogoPhoto
                $logophoto_path = $request->file('storeLogoPhoto')->store($store_photos_dir);
            } else {
                $logophoto_path = $toEdit_store->logo;
            }
            //
            $toEdit_store->update(
                [
                    'name' => $store_info['name'],
                    'email' => $store_info['email'],
                    'phone' => $store_info['phone'],
                    'adress' => 'good_eats', //$store_info['adress'],
                    'cover' => $coverphoto_path,
                    'logo' => $logophoto_path,
                    'active' => $store_info['active'],
                    'description' => $store_info['description'],
                    'can_deliver' => $store_info['canDeliver'],
                    'deliver_minimum_spend' => floatval($store_info['deliveryMinSpend']),
                    'can_pickup' => $store_info['canPickup'],
                    'pickup_minimum_spend' => floatval($store_info['pickupMinSpend']),
                    'can_table_order' => $store_info['canTableOrder'],
                    'table_oredr_minimum_spend' => floatval($store_info['tableOrderMinSpend'])
                ]
            );
            $store_hours = $toEdit_store->hour;
            $store_hours->update(
                [
                    'sat_from' => $store_info['saterday'] ? $store_info['satFrom'] : null,
                    'sat_to' => $store_info['saterday'] ? $store_info['satTo'] : null,
                    'sun_from' => $store_info['sunday'] ? $store_info['sunFrom'] : null,
                    'sun_to' => $store_info['sunday'] ? $store_info['sunTo'] : null,
                    'mon_from' => $store_info['monday'] ? $store_info['monFrom'] : null,
                    'mon_to' => $store_info['monday'] ? $store_info['monTo'] : null,
                    'tue_from' => $store_info['tuesday'] ? $store_info['tueFrom'] : null,
                    'tue_to' => $store_info['tuesday'] ? $store_info['tueTo'] : null,
                    'wed_from' => $store_info['wednesday'] ? $store_info['wedFrom'] : null,
                    'wed_to' => $store_info['wednesday'] ? $store_info['wedTo'] : null,
                    'thur_from' => $store_info['thursday'] ? $store_info['thurFrom'] : null,
                    'thur_to' => $store_info['thursday'] ? $store_info['thurTo'] : null,
                    'fri_from' => $store_info['friday'] ? $store_info['friFrom'] : null,
                    'fri_to' => $store_info['friday'] ? $store_info['friTo'] : null,
                ]
            );
            $todetach_store_cate_arr = $toEdit_store->scategories;
            $todetach_store_cate = $todetach_store_cate_arr[0];
            $todetach_store_cate->stores()->detach($toEdit_store->id);
            $toattach_store_cate = Scategory::where('id', intval($store_info['categoryId']))->get()[0];
            $toattach_store_cate->stores()->attach($toEdit_store->id);
            DB::commit();
            return response([
                'storeId' => $toEdit_store_id
            ], 200);
        } catch (\Throwable $th) {
            return response($th, 500);
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $fields = $request->validate([
            'id' => 'required|integer'
        ]);
        try {
            $store = Store::findOrFail($fields['id']);
        } catch (\Throwable $th) {
            return response([], 404);
        }
        $store->delete();
        return response([], 200);
    }
}
