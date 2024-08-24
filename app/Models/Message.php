<?php

namespace App\Models;

use App\Models\Conversation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id' ,
        'sender_id' ,
        'receiver_id',
        'read_at' ,
        'sender_deleted_at' ,
        'receiver_deleted_at' ,
        'body'
    ];

    protected $dates = ['read_at' , 'sender_deleted_at' , 'receiver_deleted_at' ];

    public function conversation(): belongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    public function isRead(): bool
    {
        return $this->read_at != null;
    }

}
