<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrder implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('Order');
    }
    public function broadcastAs()
    {
        return 'NewOrder';
    }
    public function broadcastWith()
    {
        // $order_items = $this->order->items->all();

        // $items_ = array_map(function ($item) {
        //     return [
        //         'item_id' => $item->id,
        //         'item_name' => $item->name,
        //         'item_image' => $item->image,
        //         'item_count' => $item->pivot->count,
        //         'variant' => [],
        //         'extras' => []
        //     ];
        // }, $order_items);

        // $order_variants = $this->order->variants->all();
        // $variants = [];

        // foreach ($order_variants as $variant) {
        //     $variant_item = $variant->item;
        //     $variants[$variant_item->id] = [
        //         'variant_id' => $variant->id,
        //         'variant_options' => json_decode($variant->options),
        //         'variant_count' => $variant->pivot->count
        //     ];
        // }

        // $order_extras = $this->order->extras->all();
        // $extras = [];

        // foreach ($order_extras as $extra) {
        //     $extra_item = $extra->item;
        //     if (array_key_exists($extra_item->id, $extras)) {
        //         array_push($extras[$extra_item->id], [
        //             'extra_id' => $extra->id,
        //             'extra_name' => $extra->name,
        //             'extra_price' => $extra->price
        //         ]);
        //     } else {
        //         $extras[$extra_item->id] = [[
        //             'extra_id' => $extra->id,
        //             'extra_name' => $extra->name,
        //             'extra_price' => $extra->price
        //         ]];
        //     }
        // }

        // $items = [];
        // foreach ($items_ as $item) {
        //     $item_id = $item['item_id'];
        //     $item_variant = array_filter($variants, function ($variant, $key) use ($item_id) {
        //         return $key == $item_id;
        //     }, ARRAY_FILTER_USE_BOTH);
        //     $item_extras = array_filter($extras, function ($extra, $key) use ($item_id) {
        //         return $key == $item_id;
        //     }, ARRAY_FILTER_USE_BOTH);
        //     array_push($items, [
        //         'item_id' => $item['item_id'],
        //         'item_name' => $item['item_name'],
        //         'item_image' => $item['item_image'],
        //         'item_count' => $item['item_count'],
        //         'variant' => $item_variant,
        //         'extras' => $item_extras
        //     ]);
        // }

        // return [
        //     'client_phone' => $this->order->client_phone,
        //     'created_at' => $this->order->created_at->toFormattedDateString(),
        //     'store' => [
        //         'store_id' => $this->order->store->id,
        //         'store_name' => $this->order->store->name,
        //         'store_logo' => $this->order->store->logo
        //     ],
        //     'items' => $items
        // ];

        return ['NewOrder'=>'ok'];
    }
}
