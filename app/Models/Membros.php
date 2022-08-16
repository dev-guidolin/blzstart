<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membros extends Model
{
    use HasFactory, Timestamp;

    protected $table = "membros";
    protected $fillable = [
        'membro_id',
        'is_bot',
        'nome',
        'user_name'
    ];
}
