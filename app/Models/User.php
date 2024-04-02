<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use Nette\Utils\Random;
use App\Services\SmsService;
use Laravel\Sanctum\HasApiTokens;
use App\Interfaces\MustVerifyPhone;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;


/**
 * Class User
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $password
 * @property string $phone
 * @property string $phone_verified_at
 * @property string $is_admin
 * @property string $stir
 * @property int $type
 * @property int $balance
 * @property int $region_id
 * @property int $district_id
 * @property string $passport
 * @property string $passport_date
 * @property string $passport_given
 * @property string $pinfl
 * @property string $birth_date
 * @property string $lots_member_number
 * @property string $address
 * @property string $email
 * @property string $email_verified_at
 * @property string $remember_token
 * @property string $verification_code
 * @property string $verification_code_expired_at
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Attachment $attachments
 * @property Region $region
 * @property District $district
 * @property Lot[] $lots
 * @property Message[] $messages
 *
 * @mixin Builder
 */
class User extends Authenticatable implements MustVerifyPhone, FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'phone_verified_at',
        'is_admin',
        'stir',
        'type',
        'address',
        'remember_token',
        'verification_code',
        'verification_code_expired_at',
        'region_id',
        'district_id',
        'passport',
        'passport_date',
        'passport_given',
        'balance',
        'pinfl',
        'birth_date',
        'lots_member_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::created(function(User $user) {
            $user->generateLotsMemberNumber();
        });
    }

    private function generateLotsMemberNumber(): void
    {
        $this->lots_member_number = str_pad($this->id, 10, '0', STR_PAD_LEFT);
        $this->save();
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function lots(): BelongsToMany
    {
        return $this->belongsToMany(Lot::class, 'lot_users')
            ->withPivot(['is_winner'])
            ->withTimestamps();
    }

    public function steps(): HasManyThrough
    {
        return $this->hasManyThrough(LotUserStep::class, LotUser::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderByDesc('created_at');
    }

    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    public function verifyCode(string $code): bool
    {
        if ($this->verification_code_expired_at < now()) {
            return false;
        }
        return $code === $this->verification_code;
    }

    public function hasVerifiedPhone(): bool
    {
        return !is_null($this->phone_verified_at);
    }

    public function markPhoneAsVerified(): bool
    {
        return $this->forceFill([
            'phone_verified_at' => $this->freshTimestamp(),
            'verification_code' => null,
            'verification_code_expired_at' => null,
        ])->save();
    }

    public function sendPhoneVerificationNotification(): void
    {
        $this->forceFill([
            'verification_code' => Random::generate(config('app.sms.verification_code.length'), '0-9'),
            'verification_code_expired_at' => now()->addSeconds(config('app.sms.verification_code.expired_in')),
        ])->save();

        $verifyLink = route('verify-phone');
        app(SmsService::class)->sendSms(
            $this->phone,
            <<<TEXT
Сизнинг телефон рақамингизни тасдиқлаш учун верификация коди: {$this->verification_code}

$verifyLink
TEXT
        );
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin();
    }
}
