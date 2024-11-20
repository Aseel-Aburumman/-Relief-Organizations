<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
    ];
    // protected $guard_name = 'web';
    protected $dates = ['deleted_at'];

    public function donation()
    {
        return $this->hasMany(Donation::class);
    }

    public function organization()
    {
        return $this->hasOne(Organization::class);
    }

    public function userDetail()
    {
        return $this->hasMany(UserDetail::class);
    }
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
    ];


    public static function getUsersByRole(string $role)
    {
        return self::role($role)->get();
    }

    public static function createUser(array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        return self::create($data);
    }

    public function updateUserDetails(array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $this->update($data);
        return $this;
    }



    public static function deleteUserById(int $id)
    {
        $user = self::find($id);
        return $user ? $user->delete() : false;
    }
    public static function registerUser($data)
    {
        $data['password'] = bcrypt($data['password']);
        return self::create($data);
    }


    public static function loginUser($data)
    {
        $user = self::where('email', $data['email'])->first();

        if ($user && Hash::check($data['password'], $user->password)) {
            return $user;
        }

        return null;
    }
}
