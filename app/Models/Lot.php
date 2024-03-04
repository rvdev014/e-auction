<?php

namespace App\Models;

use App\Enums\LotType;
use App\Enums\LotStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Lot
 *
 * @package App\Models
 *
 * @property int $id
 * @property LotType $type
 * @property int $lotable_id
 * @property string $lotable_type
 * @property string $apply_deadline
 * @property string $starts_at
 * @property string $ends_at
 * @property int $starting_price
 * @property int $deposit_amount
 * @property int $step_amount
 * @property LotStatus $status
 * @property string $cancel_reason
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Model $lotable
 * @property User[] $users
 * @property LotStep[] $steps
 * @property LotStep[] $activeSteps
 *
 * @mixin Builder
 */
class Lot extends Model
{
    use HasFactory;

    protected $table = 'lots';

    protected $fillable = [
        'type',
        'lotable_id',
        'lotable_type',
        'apply_deadline',
        'starts_at',
        'ends_at',
        'starting_price',
        'deposit_amount',
        'step_amount',
        'status',
        'cancel_reason',
    ];

    protected $casts = [
        'type' => LotType::class,
        'status' => LotStatus::class,
    ];

    public function lotable(): MorphTo
    {
        return $this->morphTo();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'lot_steps');
    }

    public function steps(): HasMany
    {
        return $this->hasMany(LotStep::class);
    }

    public function activeSteps(): HasMany
    {
        return $this->hasMany(LotStep::class)
            ->where('price', '>', 0)
            ->orderBy('price', 'desc');
    }
}
