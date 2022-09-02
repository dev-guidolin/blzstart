<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cobranca extends Model
{
    use HasFactory, Timestamp, SoftDeletes;

    protected $fillable = [
        'user_id',
        'valor',
        'plano',
        'validade_plano',
        'collection_id',
        'collection_status',
        'payment_id',
        'status',
        'external_reference',
        'payment_type',
        'merchant_order_id',
        'preference_id',
        'site_id',
        'processing_mode',
        'merchant_account_id',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
