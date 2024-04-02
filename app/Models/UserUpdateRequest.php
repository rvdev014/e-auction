<?php

namespace App\Models;

use App\Enums\UserUpdateRequestStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property mixed id
 * @property mixed user_id
 * @property mixed data
 * @property UserUpdateRequestStatus status
 * @property mixed created_at
 * @property mixed updated_at
 *
 * @property-read User user
 *
 * @mixin Builder
 */
class UserUpdateRequest extends Model
{
    use HasFactory;

    protected $table = 'user_update_requests';

    protected $fillable = [
        'user_id',
        'data',
        'status',
    ];

    protected $casts = [
        'data' => AsCollection::class,
        'status' => UserUpdateRequestStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
