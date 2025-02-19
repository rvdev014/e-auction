<?php

namespace App\Models;

use App\Enums\PaymentType;
use App\Enums\PaymentSubject;
use App\Observers\PaymentObserver;
use App\Observers\TourDayExpenseObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int user_id
 * @property int amount
 * @property PaymentType type
 * @property string created_at
 * @property string updated_at
 *
 * @property User user
 */
#[ObservedBy([PaymentObserver::class])]
class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'type',
        'comment',
    ];

    protected $casts = [
        'type' => PaymentType::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
