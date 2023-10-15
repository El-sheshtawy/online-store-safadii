<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'broadcast'];

//        $channels = ['database'];
//        if ($notifiable->notification_preferences['order_created']['sms'] ?? false){
//            $channels[]='vonage';
//        }
//        if ($notifiable->notification_preferences['order_created']['mail'] ?? false){
//            $channels[] ='mail';
//        }
//        if ($notifiable->notification_preferences['order_created']['broadcast'] ?? false){
//            $channels[] = 'broadcast';
//        }
//            return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->from('sheshtawy@online-store.eg')
            ->subject("New order #{$this->order->number}")
            ->greeting("Hello {$notifiable->name}")
            ->line("{$this->order->billingAddress->full_name} has been created an order, order Number:({$this->order->number})  from {$this->order->shippingAddress->country}")
            ->action('View order', url('/dashboard'))
            ->line('Thank you for using our application!');
    }

    public function toDatabase(object $notifiable): array
    {
        if (!DatabaseNotification::where([
            ['type', '=', 'App\Notifications\OrderCreatedNotification'],
            ['data->order_id', '=', $this->order->id],
        ])->first()) {
            return [
                'body' => "{$this->order->billingAddress->full_name} has been created an order, order Number:({$this->order->number})  from {$this->order->shippingAddress->country}",
                'icon' => 'fas fa-file',
                'url' => url('admin/dashboard'),
                'order_id' => $this->order->id,
            ];
        }
    }

    public function toBroadcast(object $notifiable)
    {
        return new BroadcastMessage([
            'body' => "{$this->order->billingAddress->full_name} has been created an order, order Number:({$this->order->number})  from {$this->order->shippingAddress->country}",
            'icon' => 'fas fa-file',
            'url' => url('admin/dashboard'),
            'order_id' => $this->order->id,
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
