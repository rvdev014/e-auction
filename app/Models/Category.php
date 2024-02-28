<?php

namespace App\Models;

use App\Enums\CategoryType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;


/**
 * Class Category
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $title
 * @property CategoryType $type
 * @property int $parent_id
 *
 * @mixin Builder
 */
class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    public $timestamps = false;

    protected $fillable = [
        'title',
        'type',
        'parent_id',
    ];

    protected $casts = [
        'type' => CategoryType::class,
    ];

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent(): HasMany
    {
        return $this->hasMany(Category::class, 'id', 'parent_id');
    }

    public function transports(): MorphToMany
    {
        return $this->morphedByMany(Transport::class, 'categorizable');
    }
}
