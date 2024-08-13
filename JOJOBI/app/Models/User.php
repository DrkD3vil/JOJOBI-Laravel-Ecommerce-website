<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'userid',
        'uuid',
        'name',
        'email',
        'phone',
        'address',
        'profile_image',
        'usertype',
        'blocked',
        'password',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->userid = self::generateUniqueIdentifier();
            if (!$user->uuid) {
                $user->uuid = (string) str::uuid(); // Generate UUID if not set
            }
        });

    }

    /**
     * Generate a unique identifier.
     *
     * @return string
     */
    public static function generateUniqueIdentifier()
    {
        do {
            $identifier = 'U' . strtoupper(Str::random(5)); // Adjust the length as needed
        } while (self::where('userid', $identifier)->exists());

        return $identifier;
    }

    /**
     * Set the phone number with country code and ensure 11 digits.
     *
     * @param string $value
     * @return void
     */
    public function setPhoneAttribute($value)
    {
        // Ensure phone number starts with +880 and is 11 digits long
        $value = ltrim($value, '0'); // Remove leading zero if present
        if (!str_starts_with($value, '+880')) {
            $value = '+880' . $value;
        }
        $this->attributes['phone'] = $value;
    }

    /**
     * Get the phone number with country code.
     *
     * @param string $value
     * @return string
     */
    public function getPhoneAttribute($value)
    {
        return '+880' . ltrim($value, '+880');
    }
}
