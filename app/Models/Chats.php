<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chats extends Model
{
    use HasFactory, Timestamp, SoftDeletes;
    protected $table = 'chats';
    protected $fillable = [
        'chat_id',
        'name',
        'chat_obs',
        'user_id',
        'total_membros',
        'is_admin',
    ];
}
