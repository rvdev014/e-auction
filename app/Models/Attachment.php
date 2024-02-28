<?php

namespace App\Models;

use App\Enums\AttachmentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * App\Models\Attachment
 *
 * @property int $id
 * @property string $file_name
 * @property string $file_path
 * @property string $file_type
 * @property string $file_size
 * @property AttachmentType $type
 * @property integer $attachable_id
 * @property string $attachable_type
 *
 * @property-read Model $attachable
 *
 * @mixin Builder
 */
class Attachment extends Model
{
    use HasFactory;

    protected $table = 'attachments';

    public $timestamps = false;

    protected $fillable = [
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'type',
    ];

    protected $casts = [
        'type' => AttachmentType::class,
    ];

    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }

    protected static function booted(): void
    {
        static::deleted(function (Attachment $attachment) {
            if (Storage::disk('public')->exists($attachment->file_path)) {
                Storage::disk('public')->delete($attachment->file_path);
            }
        });
    }
}
