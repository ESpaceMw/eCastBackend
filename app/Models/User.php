<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Alerts;
use App\Models\BasicInfo;
use Laravel\Cashier\Billable;
use App\Models\Message;
use App\Models\Channels;
use App\Models\RecentSearches;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'gender',
        'country',
        'city',
        'date_of_birth',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the basic_info associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function basic_info()
    {
        return $this->hasOne(BasicInfo::class);
    }

    /**
     * Get all of the alerts for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function alerts()
    {
        return $this->hasMany(Alerts::class);
    }

    /**
     * Get all of the messages for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function messages()
    {
        return $this->hasMany(Message::class,'sender_id');
    }

    /**
     * Get all of the channels for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function channels()
    {
        return $this->hasOne(Channels::class);
    }

    /**
     * Get all of the recent searches for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recentSearches()
    {
        return $this->hasMany(RecentSearches::class);
    }

}
