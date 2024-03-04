<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $lot_id
 * @property int $user_id
 * @property bool $is_winner
 * @property int $price
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Lot $lot
 * @property User $user
 *
 * @mixin Builder
 */
class LotStep extends Model
{
    use HasFactory;

    protected $table = 'lot_steps';

    protected $fillable = [
        'lot_id',
        'user_id',
        'price',
    ];

    public function lot(): BelongsTo
    {
        return $this->belongsTo(Lot::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
