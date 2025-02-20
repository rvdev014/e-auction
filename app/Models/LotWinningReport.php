<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class LotWinningReport
 * @package App\Models
 *
 * @property int $id
 * @property int $lot_id
 * @property int $user_id
 *
 * @property Lot $lot
 * @property User $user
 */
class LotWinningReport extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function lot(): BelongsTo
    {
        return $this->belongsTo(Lot::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
