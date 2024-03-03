<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class District
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property int $region_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User[] $users
 * @property Region $region
 *
 * @mixin Builder
 */
class District extends Model
{
    use HasFactory;

    protected $table = 'districts';

    protected $fillable = [
        'name',
        'region_id',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
}
