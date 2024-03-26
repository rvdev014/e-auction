<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $lot_user_id
 * @property int $price
 * @property string $created_at
 * @property string $updated_at
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

    public function lotUser(): BelongsTo
    {
        return $this->belongsTo(LotUser::class);
    }
}
