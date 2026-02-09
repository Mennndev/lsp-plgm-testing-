<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'nama',
        'email',
        'password',
        'no_hp',
        'role',
        'alamat',
        'status_aktif',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status_aktif' => 'boolean',
        ];
    }
    public function sendPasswordResetNotification($token)
{
    $this->notify(new ResetPasswordNotification($token));
}

    public function notifications()
    {
        return $this->hasMany(Notification::class)->orderByDesc('created_at');
    }

    public function unreadNotifications()
    {
        return $this->notifications()->where('is_read', false);
    }

    public function unreadNotificationCount()
    {
        return $this->unreadNotifications()->count();
    }

   public function pengajuanYangDiAses()
{
    return $this->hasMany(PengajuanSkema::class, 'asesor_id');
}

    // Chat relationships
    public function chats()
    {
        return $this->hasMany(Chat::class, 'user_id');
    }

    public function assignedChats()
    {
        return $this->hasMany(Chat::class, 'admin_id');
    }

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }}