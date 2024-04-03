<?php

namespace App\Models;

use App\Enums\AttachmentType;
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
 * @property string $body_number
 * @property string $curb_weight
 * @property string $unladen_weight
 * @property string $engine_number
 * @property string $engine_power
 * @property string $fuel_type
 * @property string $seats_amount
 * @property string $standings_amount
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Lot $lots
 * @property Category $categories
 * @property Attachment[] $attachments
 * @property Attachment[] $mediaAttachments
 * @property Attachment[] $docAttachments
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
        'body_number',
        'curb_weight',
        'unladen_weight',
        'engine_number',
        'engine_power',
        'fuel_type',
        'seats_amount',
        'standings_amount',
    ];

    public static function label(string $key): string
    {
        if (array_key_exists($key, self::attributeLabels())) {
            return self::attributeLabels()[$key];
        }
        return ucfirst($key);
    }

    public static function attributeLabels(): array
    {
        return [
            'name' => 'Номи',
            'owner' => 'Автотранспорт эгаси',
            'car_number' => 'Давлат рақами',
            'year_of_issue' => 'Ишлаб чиқарилган йили',
            'color' => 'Ранги',
            'technical_condition' => 'Техник ҳолати',
            'contract' => 'Шартнома',
            'address' => 'Манзил',
            'additional_info' => 'Қўшимча маълумот',
            'additional_info2' => 'Қўшимча маълумот 2',
            'additional_info3' => 'Қўшимча маълумот 3',
            'model' => 'Русуми/Модели',
            'body_number' => 'Кузов/Шасси рақами',
            'curb_weight' => 'Тўла вазни',
            'unladen_weight' => 'Юксиз вазни',
            'engine_number' => 'Двигатель рақами',
            'engine_power' => 'Двигатель қуввати',
            'fuel_type' => 'Йонилғи тури',
            'seats_amount' => 'Ўтирадиган жойлар сони',
            'standings_amount' => 'Тик турадиган жойлар сони',
            'created_at' => 'Яратилган сана',
            'updated_at' => 'Янгиланган сана',

            'mediaAttachments' => 'Медиа файллар',
            'docAttachments' => 'Документлар',
        ];
    }

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
