<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Region
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User[] $users
 * @property District[] $districts
 *
 * @mixin Builder
 */
class Region extends Model
{
    use HasFactory;

    protected $table = 'regions';

    protected $fillable = [
        'name',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function districts(): HasMany
    {
        return $this->hasMany(District::class);
    }
}
