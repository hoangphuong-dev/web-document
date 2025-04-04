<?php

namespace App\Events\Payment;

use Helpers\Formatter;
use App\Models\MoneyNotLogin;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotEnoughMoneyNotLogin implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $queue = 'notification';
    
    /**
     * Create a new event instance.
     */
    public function __construct(
        public MoneyNotLogin $transaction,
        public int $moneyAdd
    ) {
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'PaymentNotEnoughNotLogin';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        $message = 'Bạn phải nạp tối thiểu ' . Formatter::numberFormatVn($this->transaction->money_need) . 'để tải tài liệu.<br>Bạn đã nạp ' . Formatter::numberFormatVn($this->moneyAdd);
        return [
            'message' => $message
        ];
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('App.Models.UserGuest.' . $this->transaction->guest_id)
        ];
    }
}
