<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Broadcasting\Channel;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

class MessageSent extends Notification implements ShouldBroadcast
{
    use Queueable;

    public $user;
    public $message;
    public $conversation;
    public $receiverId;
    /**
     * Create a new notification instance.
     */
    public function __construct($user ,$message ,$conversation ,$receiverId)
    {
        //
        $this->user = $user;
        $this->message = $message;
        $this->conversation = $conversation;
        $this->receiverId = $receiverId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['broadcast'];
    }

    /**
    * Get the broadcastable representation of the notification.
    */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return (new BroadcastMessage([
            'user_id' => $this->user->id,
            'conversation_id' => $this->conversation->id,
            'message_id' => $this->message->id,
            'receiver_id' => $this->receiverId,
        ]));
    }

}
