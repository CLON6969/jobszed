<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'product_id',
        'reply_to_id',
        'content',
        'media_path',
        'media_type',
        'channel',
        'status',
        'is_deleted',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_deleted' => 'boolean',
    ];

    public function sender()  { return $this->belongsTo(User::class, 'sender_id'); }
    public function receiver(){ return $this->belongsTo(User::class, 'receiver_id'); }
    public function product() { return $this->belongsTo(Product::class); }
    public function replyTo() { return $this->belongsTo(Message::class, 'reply_to_id'); }

    // ✅ Helper for chat between two users
    public function scopeBetween($query, $user1, $user2)
    {
        return $query->where(function ($q) use ($user1, $user2) {
            $q->where('sender_id', $user1)->where('receiver_id', $user2);
        })->orWhere(function ($q) use ($user1, $user2) {
            $q->where('sender_id', $user2)->where('receiver_id', $user1);
        });
    }

    public function getMediaUrlAttribute()
    {
        return $this->media_path ? asset('storage/' . $this->media_path) : null;
    }
}
