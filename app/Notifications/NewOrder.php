<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrder extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable)
    {
        $order_id = $this->order->id;
        $order_items = $this->order->items->all();

        $items_ = array_map(function ($item) {
            return [
                'item_id' => $item->id,
                'item_name' => $item->name,
                'item_image' => $item->image,
                'item_count' => $item->pivot->count,
                'variant' => [],
                'extras' => []
            ];
        }, $order_items);

        $order_variants = $this->order->variants->all();
        $variants = [];

        foreach ($order_variants as $variant) {
            $variant_item = $variant->item;
            $variants[$variant_item->id] = [
                'variant_id' => $variant->id,
                'variant_options' => json_decode($variant->options),
                'variant_count' => $variant->pivot->count
            ];
        }

        $order_extras = $this->order->extras->all();
        $extras = [];

        foreach ($order_extras as $extra) {
            $extra_item = $extra->item;
            if (array_key_exists($extra_item->id, $extras)) {
                array_push($extras[$extra_item->id], [
                    'extra_id' => $extra->id,
                    'extra_name' => $extra->name,
                    'extra_price' => $extra->price
                ]);
            } else {
                $extras[$extra_item->id] = [[
                    'extra_id' => $extra->id,
                    'extra_name' => $extra->name,
                    'extra_price' => $extra->price
                ]];
            }
        }

        $items = [];
        foreach ($items_ as $item) {
            $item_id = $item['item_id'];
            $item_variant = array_filter($variants, function ($variant, $key) use ($item_id) {
                return $key == $item_id;
            }, ARRAY_FILTER_USE_BOTH);
            $item_extras = array_filter($extras, function ($extra, $key) use ($item_id) {
                return $key == $item_id;
            }, ARRAY_FILTER_USE_BOTH);
            array_push($items, [
                'item_id' => $item['item_id'],
                'item_name' => $item['item_name'],
                'item_image' => $item['item_image'],
                'item_count' => $item['item_count'],
                'variant' => $item_variant,
                'extras' => $item_extras
            ]);
        }

        return [
            'order_id' => $order_id,
            'client_phone' => $this->order->client_phone,
            'created_at' => $this->order->created_at->toFormattedDateString(),
            'store' => [
                'store_id' => $this->order->store->id,
                'store_name' => $this->order->store->name,
                'store_logo' => $this->order->store->logo
            ],
            'items' => $items
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
