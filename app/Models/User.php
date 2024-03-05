<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use Nette\Utils\Random;
use Laravel\Sanctum\HasApiTokens;
use App\Interfaces\MustVerifyPhone;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


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
 * @property int $balance
 * @property int $region_id
 * @property int $district_id
 * @property string $passport
 * @property string $passport_date
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
        'address',
        'remember_token',
        'verification_code',
        'verification_code_expired_at',
        'region_id',
        'district_id',
        'passport',
        'passport_date',
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

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }

    public function lots(): BelongsToMany
    {
        return $this->belongsToMany(Lot::class, 'lot_steps')
            ->withPivot(['price'])
            ->withTimestamps();
    }

    public function steps(): HasMany
    {
        return $this->hasMany(LotStep::class);
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
        //        $this->notify(new SendVerifySMS);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin();
    }
}
