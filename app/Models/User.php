<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\HasPermissionsTrait;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasPermissionsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'phone', 'email', 'password', 'active'
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

    /**
     * Returns the name of the user by concatinating
     * his first and last name
     * 
     * @return string
     */
    public function name()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Get all orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function stores()
    {
        return $this->belongsToMany(Store::class, 'user_stores');
    }

    public function me()
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'active' => $this->active,
            'roles' => $this->roles()->get(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }

    /**
     * Trims fields of this model
     * 
     * @param  array  $data
     * @return array  $data
     */
    public static function trimMyData(array $data)
    {
        if(isset($data['first_name']) && trim($data['first_name']) != '') {
            $data['first_name'] = trim($data['first_name']);
        }
        if(isset($data['last_name']) && trim($data['last_name']) != '') {
            $data['last_name'] = trim($data['last_name']);
        }
        if(isset($data['email']) && trim($data['email']) != '') {
            $data['email'] = trim($data['email']);
        }
        if(isset($data['phone']) && trim($data['phone']) != '') {
            $data['phone'] = trim($data['phone']);
        }
        if(isset($data['address']) && trim($data['address']) != '') {
            $data['address'] = trim($data['address']);
        }
        if(isset($data['password']) && trim($data['password']) != '') {
            $data['password'] = trim($data['password']);
        }
        return $data;
    }
}