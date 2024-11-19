<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'email',
        'password',
    ];

    protected $dates = ['deleted_at'];

    public function need()
    {
        return $this->hasMany(Need::class);
    }
    public function userDetail()
    {
        return $this->hasMany(UserDetail::class);
    }
    public function image()
    {
        return $this->hasMany(Image::class);
    }


    public static function createOrganization(array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        return self::create($data);
    }

    public function updateOrganization(array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $this->update($data);
        return $this;
    }



    public static function deleteOrganizationById(int $id)
    {
        $user = self::find($id);
        return $user ? $user->delete() : false;
    }
    public static function registerUser($data)
    {
        $data['password'] = bcrypt($data['password']);
        return self::create($data);
    }
}
