<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'reference',
        'user_id',
        'payment_method',
        'provider',
        'amount',
        'fee',
        'bearer',
        'source',
        'currency',
        'status',
        'provider_status',
        'provider_reference',
        'provider_data',
        'phone',
        'account_name',
        'operator',
        'operator_transaction_id',
        'country',
        'failure_reason',
        'processed_at',
        'initiated_at',
        'completed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'fee' => 'decimal:2',
        'provider_data' => 'array',
        'processed_at' => 'datetime',
        'initiated_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function generateTransactionId(): string
    {
        return 'TXN_' . strtoupper(uniqid());
    }

    public static function generateReference(): string
    {
        return 'REF_' . strtoupper(uniqid());
    }
}
