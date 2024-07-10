<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserRoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
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
        'role'
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

    public function customer()
    {
        return $this->hasOne(Customer::class); 
    }

    public function setRoleAttribute($value)
    {
        switch (strtoupper($value)) {
            case 'ADMIN':
                $this->attributes['role'] = UserRoleEnum::ADMIN;
                break;
            case 'WAITER':
                $this->attributes['role'] = UserRoleEnum::WAITER;
                break;
            case 'CUSTOMER':
                $this->attributes['role'] = UserRoleEnum::CUSTOMER;
                break;
            default:
                $this->attributes['role'] = UserRoleEnum::CUSTOMER;
                break;
        }
    }
}
