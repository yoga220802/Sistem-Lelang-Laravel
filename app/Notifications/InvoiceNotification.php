<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoiceNotification extends Notification
{
    use Queueable;

    protected $auction;

    public function __construct($auction)
    {
        $this->auction = $auction;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Invoice for Auction Item: ' . $this->auction->item->name)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Congratulations! You have won the auction for the item: ' . $this->auction->item->name)
            ->line('Final Price: Rp. ' . number_format($this->auction->current_price, 2))
            ->line('Please complete the payment to finalize your purchase.')
            ->action('View Auction', route('auctions.show', $this->auction->id))
            ->line('Thank you for participating in our auction!');
    }

    public function toArray($notifiable)
    {
        return [
            'auction_id' => $this->auction->id,
            'item_name' => $this->auction->item->name,
            'final_price' => $this->auction->current_price,
        ];
    }
}