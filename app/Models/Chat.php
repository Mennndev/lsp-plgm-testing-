<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        'user_id',
        'admin_id',
        'subject',
        'status',
        'last_message',
        'last_message_by',
        'last_message_at',
        'closed_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
        'closed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class)->orderBy('created_at', 'asc');
    }

    public function lastMessageSender()
    {
        return $this->belongsTo(User::class, 'last_message_by');
    }

    // Accessors
    public function getUnreadCountAttribute()
    {
        if (!auth()->check()) return 0;
        
        $messageCount = $this->messages()
            ->where('user_id', '!=', auth()->id())
            ->count();
            
        return $messageCount;
    }

    // Scopes
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeWaiting($query)
    {
        return $query->where('status', 'waiting');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Methods
    public function closeChat()
    {
        $this->update([
            'status' => 'closed',
            'closed_at' => now(),
        ]);
    }

    public function assignAdmin($adminId)
    {
        $this->update([
            'admin_id' => $adminId,
            'status' => 'open',
        ]);
    }

    public function addMessage($userId, $message, $attachment = null)
    {
        $msg = $this->messages()->create([
            'user_id' => $userId,
            'message' => $message,
            'attachment' => $attachment,
        ]);

        $this->update([
            'last_message' => $message,
            'last_message_by' => $userId,
            'last_message_at' => now(),
        ]);

        return $msg;
    }
}
