<?php

namespace App\Models;

use DateTime;
use App\Enums\LotType;
use App\Enums\LotStatus;
use App\Enums\LotPaymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * Class Lot
 *
 * @package App\Models
 *
 * @property int $id
 * @property LotType $type
 * @property int $lotable_id
 * @property string $lotable_type
 * @property string $number
 * @property DateTime $starts_at
 * @property DateTime $payment_deadline
 * @property DateTime $apply_deadline
 * @property DateTime $reports_at
 * @property int $starting_price
 * @property int $deposit_amount
 * @property int $payment_status
 * @property int $step_amount
 * @property LotStatus $status
 * @property string $cancel_reason
 * @property bool $is_cancelled
 * @property DateTime $created_at
 * @property DateTime $updated_at
 *
 * @property Transport|Model $lotable
 * @property User[] $users
 * @property LotUserStep[] $steps
 * @property LotUserStep $lastStep
 * @property LotUser $winner
 * @property User $winnerUser
 * @property LotUser[] $lotUsers
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
        'starting_price',
        'deposit_amount',
        'step_amount',
        'status',
        'payment_status',
        'payment_deadline',
        'reports_at',
        'number',
        'is_cancelled',
        'cancel_reason',
    ];

    protected $casts = [
        'type' => LotType::class,
        'status' => LotStatus::class,
        'payment_status' => LotPaymentStatus::class,
        'apply_deadline' => 'datetime',
        'starts_at' => 'datetime',
        'payment_deadline' => 'datetime',
        'reports_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::created(function(Lot $lot) {
            $lot->generateNumber();
        });
    }

    public function lotable(): MorphTo
    {
        return $this->morphTo();
    }

    public function winner(): HasOne
    {
        return $this->hasOne(LotUser::class)->where('is_winner', true);
    }

    public function winnerUser(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, LotUser::class)->where('is_winner', true);
    }

    public function lotUsers(): HasMany
    {
        return $this->hasMany(LotUser::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'lot_users');
    }

    public function steps(): HasManyThrough
    {
        return $this->hasManyThrough(LotUserStep::class, LotUser::class)
            ->orderBy('price', 'desc');
    }

    public function lastStep(): HasOneThrough
    {
        return $this->hasOneThrough(LotUserStep::class, LotUser::class)
            ->orderBy('price', 'desc');
    }

    public function scopeActive(Builder $query)
    {
        return $query
            ->where('status', '!=', LotStatus::Ended)
            ->where('is_cancelled', false);
    }

    public function scopeEnded(Builder $query)
    {
        return $query->where('status', LotStatus::Ended);
    }

    public function scopeCancelled(Builder $query)
    {
        return $query->where('is_cancelled', true);
    }

    public function generateNumber(): void
    {
        $this->number = str_pad($this->id, 5, '0', STR_PAD_LEFT);
        $this->save();
    }

    public function isValid(): bool
    {
        return !$this->is_cancelled && $this->users()->count() > 1;
    }

    public function isActive(): bool
    {
        return $this->isValid() && $this->status === LotStatus::Active;
    }

    public function isCanBeStarted(): bool
    {
        return $this->isValid() && $this->starts_at <= now() && $this->status === LotStatus::Active;
    }

    public function isCanBeEnded(): bool
    {
        if (!$this->lastStep) {
            return false;
        }
        return $this->status === LotStatus::Started && $this->lastStep->created_at->addMinutes(10) < now();
    }

    public function isEnded(): bool
    {
        return $this->status === LotStatus::Ended;
    }

    public function isStarted(): bool
    {
        return $this->isValid() && $this->starts_at < now() && $this->status === LotStatus::Started;
    }

    public function hasSteps(): bool
    {
        return $this->steps()->exists();
    }

    public function isApplied(): bool
    {
        if (!auth()->user()) {
            return false;
        }

        return $this->users()->where('user_id', auth()->user()->id)->exists();
    }

    public function isApplyExpired(): bool
    {
        return $this->apply_deadline < now();
    }

    public function isStartedAndApplied(): bool
    {
        return $this->isStarted() && $this->isApplied();
    }

    public function getLink(): string
    {
        return route('lot.details', ['lot' => $this->id]);
    }

}
