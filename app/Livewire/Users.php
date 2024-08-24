<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;

class Users extends Component
{
    public function message($userId)
    {
        $authUserId = Auth::user()->id;

        $existingConversation = Conversation::where(function ($query) use ($authUserId ,$userId){
            $query->where('sender_id' , $authUserId)
                ->where('receiver_id' , $userId);
        })->orWhere(function ($query) use ($authUserId ,$userId){
            $query->where('sender_id' , $userId)
                ->where('receiver_id' , $authUserId);
        })->first();

        if($existingConversation){
            return redirect()->route('chat' , ['query' => $existingConversation->id ]);
        }

        $createdConversation = Conversation::create([
            'sender_id' => $authUserId ,
            'receiver_id' => $userId ,
        ]);
        return redirect()->route('chat' , ['query' => $createdConversation->id ]);
    }

    public function render()
    {
        return view('livewire.users' , [
            'users' => User::where('id' , '!=' , Auth::user()->id)->get(),
        ]);
    }
}
