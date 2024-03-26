<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Message
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $title
 * @property string $body
 * @property int $user_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user
 *
 * @mixin Builder
 */
class Message extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
