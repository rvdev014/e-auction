<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $lot_id
 * @property int $user_id
 * @property bool $is_winner
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Lot $lot
 * @property User $user
 * @property LotUserStep $lastStep
 * @property LotUserStep[] $steps
 *
 * @mixin Builder
 */
class LotUser extends Model
{
    use HasFactory;

    protected $table = 'lot_users';

    protected $fillable = [
        'lot_id',
        'user_id',
        'is_winner'
    ];

    public function lot(): BelongsTo
    {
        return $this->belongsTo(Lot::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function steps(): HasMany
    {
        return $this->hasMany(LotUserStep::class);
    }

    public function lastStep(): HasOne
    {
        return $this->hasOne(LotUserStep::class)->orderByDesc('price');
    }
}
