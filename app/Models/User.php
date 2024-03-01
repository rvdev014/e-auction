<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Services\SmsService;
use Laravel\Sanctum\HasApiTokens;
use App\Interfaces\MustVerifyPhone;
use Illuminate\Support\Facades\Date;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


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
 * @property string $address
 * @property string $email
 * @property string $remember_token
 * @property string $verification_code
 * @property string $verification_code_expired_at
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Attachment $attachments
 *
 * @mixin Builder
 */
class User extends Authenticatable implements MustVerifyPhone
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
        'password' => 'hashed',
    ];

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }

    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    public function verifyCode(string $code): bool
    {
        if (!$this->verification_code || !empty($this->phone_verified_at)) {
            return false;
        }
        return $this->verification_code === $code;
    }

    public function hasVerifiedPhone(): bool
    {
        return $this->phone_verified_at !== null;
    }

    public function markPhoneAsVerified(): bool
    {
        return $this->forceFill([
            'phone_verified_at' => Date::now(),
            'verification_code' => null,
            'verification_code_expired_at' => null,
        ])->save();
    }

    public function getPhoneForVerification(): string
    {
        // TODO: Implement getPhoneForVerification() method.
    }
}
