<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'chat_id',
        'user_id',
        'message',
        'attachment',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessors
    public function getIsAdminAttribute()
    {
        return $this->user->role === 'admin';
    }

    public function getFormattedTimeAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
