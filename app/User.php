<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use QiuTuleng\PhoneVerificationCodeGrant\Interfaces\PhoneVerificationCodeGrantUserInterface;

class User extends Authenticatable implements PhoneVerificationCodeGrantUserInterface
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'city_id', 'mobile'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function ads()
    {
        return $this->hasMany('App\Ad');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function createAccessToken(): string
    {
        return $this->createToken('token')
            ->accessToken;
    }

    /**
     * Find or create a user by phone number
     *
     * @param $phoneNumber
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function findOrCreateForPassportVerifyCodeGrant($phoneNumber)
    {
        // If you need to automatically register the user.
        // return static::firstOrCreate(['mobile' => $phoneNumber]);

        // If the phone number is not exists in users table, will be fail to authenticate.
        return static::where('mobile', '=', $phoneNumber)->first();
    }

    /**
     * Check the verification code is valid.
     *
     * @param $verificationCode
     * @return boolean
     */
    public function validateForPassportVerifyCodeGrant($verificationCode)
    {
        // Check verification code is valid.
        // return \App\Code::where('mobile', $this->mobile)->where('code', '=', $verificationCode)->where('expired_at', '>', now()->toDatetimeString())->exists();
        return true;
    }
}
