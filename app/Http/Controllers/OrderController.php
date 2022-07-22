<?php

namespace App\Http\Controllers;

use App\Events\NewOrder;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Store;
use App\Models\User;
use App\Notifications\NewOrder as NotificationsNewOrder;
use Illuminate\Http\Request;

class OrderController extends Controller
{


    public function getLastOrderId()
    {
        try {
            $max_order_id = Order::max('id');
            return response($max_order_id, 200);
        } catch (\Throwable $th) {
            return response($th, 500);
        }
    }

    public function getNewOrders(Request $request)
    {
        // $last_order_Id = $request->lastOrderId;
        // $new_orders = Order::where('id', '>', $last_order_Id)->get();
        // if (count($new_orders) > 0) {
        //     $response = [];
        //     foreach ($new_orders as $new_order) {
        //         $response_el = [];
        //         $client_phone = $new_order->client_phone;
        //         $orderPrice = $new_order->price;
        //         $items = $new_order->items;
        //         $response_el = [
        //             'id' => $new_order->id,
        //             'client_phone' => $client_phone,
        //             'orderPrice' => $orderPrice,
        //             'items' => $items
        //         ];
        //         array_push($response, $response_el);
        //     }
        //     return response($response, 200);
        // } else {
        //     return response('no_new_orders', 200);
        // }

        $user = User::where('email', 'werad.saoud@gmail.com')->get()[0];
        $unreadNotifications = $user->unreadNotifications;
        return response($unreadNotifications, 200);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('email', 'werad.saoud@gmail.com')->get()[0];
        $unreadNotifications = $user->unreadNotifications;
        return response($unreadNotifications, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function changeOrderStatus(Request $request)
    {
        $order_id = $request->orderId;
        $notification_id = $request->notificationId;
        $order = Order::where('id', $order_id)->get()[0];
        $user = User::where('email', 'werad.saoud@gmail.com')->get()[0];
        foreach ($user->unreadNotifications as $notification) {
            if($notification->id == $notification_id){
                $notification->markAsRead();
            }
        }
        //$order->update(['status'=>'ready']);
        //$unreadNotifications = $user->unreadNotifications;
        return response([], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        try {
            // $client_phone_number = $request->phoneNumber;
            // $store_id = $request->store_id;
            // $$item_id = $request->item_id;
            // $variant_id = $request->variant_id;
            // $extras_ids = $request->extras_ids;
            // $count = $request->count;
            // $orderItem_price = $request->orderItem_price;
            $order_items = $request->order;
            $store_id = 0;
            $client_phone_number = '';
            if (count($order_items) > 0) {
                $store_id = $order_items[0]['store_id'];
                $client_phone_number = $order_items[0]['phoneNumber'];
            }
            $order = new Order([
                'client_phone' => $client_phone_number,
                'price' => 0,
                'status' => 'new'
            ]);
            // $order->save();
            // 
            $store = Store::where('id', $store_id)->get()[0];
            $store->orders()->save($order);
            $saved_order = Order::where('id', $order->id)->get()[0];
            $total_price = 0;
            foreach ($order_items as $order_item) {
                if ($order_item['variant_id'] == '') {
                    $saved_order->items()->attach($order_item['item_id'], ['count' => $order_item['count']]);
                } else {
                    $saved_order->items()->attach($order_item['item_id'], ['count' => 0]);
                    $saved_order->variants()->attach($order_item['variant_id'], ['count' => $order_item['count']]);
                }
                $saved_order->extras()->attach($order_item['extras_ids']);
                $total_price = $total_price + doubleval($order_item['orderItem_price']);
                $saved_order->update(['price' => $total_price]);
            }
            event(new NewOrder($saved_order));
            //auth('web')->user()->notify(new NotificationsNewOrder($saved_order));
            $user = User::where('email', 'werad.saoud@gmail.com')->get()[0];
            $user->notify(new NotificationsNewOrder($saved_order));
            return response(['tok'], 200);
        } catch (\Throwable $th) {
            return response($th, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderRequest  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
