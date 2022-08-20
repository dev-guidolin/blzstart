<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoubleSequence extends Model
{
    use HasFactory, SoftDeletes, Timestamp;
    protected $table = "sequence_doubles";
    protected $fillable = [
        'user_id',
        'chat_id',
        'sequencia',
        'titulo',
        'descricao',
        'lenght',
        'entrada',
        'acertos'
    ];

    public $timestamps = true;

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function chats(): HasMany
    {
        return $this->hasMany(Chats::class);
    }
}
