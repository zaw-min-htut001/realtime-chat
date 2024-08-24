<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use Livewire\Component;
use App\Notifications\MessageSent;
use Illuminate\Support\Facades\Auth;

class ChatBox extends Component
{
    public $selectedConversation;
    public $paginate_var = 10;

    #[Validate('required|string')]
    public $body;

    public $loadedMessages;

    public function getListeners()
    {
        $auth_id = Auth::user()->id;

        return [
            "echo-private:App.Models.User.{$auth_id},.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated" => 'broadcastedNotifications'
        ];
    }

    public function broadcastedNotifications($event)
    {
        if($event['type'] == MessageSent::class){
            if($event['conversation_id'] == $this->selectedConversation->id){
                $this->dispatch('scroll-bottom' , 'refresh');

                $newMessage = Message::find($event['message_id']);

                $this->loadedMessages->push($newMessage);

            }
        }
    }
    public function loadMessage()
    {
        $this->loadedMessages =Message::where('conversation_id' , $this->selectedConversation->id)->get();

        return $this->loadedMessages;
    }

    public function sendMessage()
    {
        $createdmessage = Message::create([
            'conversation_id'  => $this->selectedConversation->id,
            'sender_id'  => Auth::user()->id ,
            'receiver_id' => $this->selectedConversation->getReceiver()->id,
            'body' => $this->body
        ]);
        $this->reset('body');
        $this->dispatch('scroll-bottom');
        $this->loadedMessages->push($createdmessage);

        $this->selectedConversation->updated_at=now();
        $this->selectedConversation->save();
        $this->dispatch('refresh');

        // broadcast
        $this->selectedConversation->getReceiver()
            ->notify(new MessageSent(
                Auth::user(),
                $createdmessage,
                $this->selectedConversation,
                $this->selectedConversation->getReceiver()->id
            ));
    }

    public function mount()
    {
        $this->loadMessage();
    }
    public function render()
    {
        return view('livewire.chat.chat-box');
    }
}
