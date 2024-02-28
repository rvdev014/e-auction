<?php

namespace App\Models;

use App\Enums\AttachmentType;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use ShiftOneLabs\LaravelCascadeDeletes\CascadesDeletes;

/**
 * Class Transport
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $owner
 * @property string $car_number
 * @property string $year_of_issue
 * @property string $color
 * @property string $technical_condition
 * @property string $contract
 * @property string $address
 * @property string $additional_info
 * @property string $additional_info2
 * @property string $additional_info3
 * @property string $model
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Lot $lots
 * @property Category $categories
 * @property Collection<Attachment> $attachments
 * @property Collection<Attachment> $mediaAttachments
 * @property Collection<Attachment> $docAttachments
 *
 * @mixin Builder
 */
class Transport extends Model
{
    use HasFactory;
    use CascadesDeletes;

    protected $table = 'transports';

    protected $cascadeDeletes = ['attachments', 'categories'];

    protected $fillable = [
        'name',
        'owner',
        'car_number',
        'year_of_issue',
        'color',
        'technical_condition',
        'contract',
        'address',
        'additional_info',
        'additional_info2',
        'additional_info3',
        'model',
    ];

    public function lots(): MorphMany
    {
        return $this->morphMany(Lot::class, 'lotable');
    }

    public function categories(): MorphToMany
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function mediaAttachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable')->where('type', AttachmentType::Media->value);
    }

    public function docAttachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable')->where('type', AttachmentType::Document->value);
    }
}
