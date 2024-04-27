<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $lot_user_id
 * @property int $price
 * @property DateTime $created_at
 * @property DateTime $updated_at
 *
 * @property LotUser $lotUser
 *
 * @mixin Builder
 */
class LotUserStep extends Model
{
    use HasFactory;

    protected $table = 'lot_user_steps';

    protected $fillable = [
        'lot_user_id',
        'price',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function lotUser(): BelongsTo
    {
        return $this->belongsTo(LotUser::class);
    }
}
