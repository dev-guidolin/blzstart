<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Planos extends Model
{
    use HasFactory, Timestamp, SoftDeletes;

    protected $fillable = [
        'nome',
        'valor',
        'validade',
    ];

    public function user() : HasOne
    {
        return $this->hasOne(User::class);
    }
}
