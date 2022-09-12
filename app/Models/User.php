<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'mensalidade',
        'status',
        'level',
        'whatsapp_id',
        'telegram_id',
        'whatsapp_token',
        'telegram_token',
        'remember_token',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function doubleSequence() : HasMany
    {
        return $this->hasMany(DoubleSequence::class);
    }
    public function chats() : HasMany
    {
        return  $this->hasMany(Chats::class);
    }
    public function cobranca() : HasMany
    {
        return $this->hasMany(Cobranca::class);
    }
    
    public function plano() : BelongsTo
    {
        return $this->belongsTo(Planos::class);
    }

}
