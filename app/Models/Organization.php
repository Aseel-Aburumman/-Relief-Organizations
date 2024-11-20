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
        'user_id',
        'contact_info',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public static function createOrganization(array $data)
    {
        return self::create($data);
    }


    public static function getAllOrganization()
    {
        return self::all();
    }


    public static function getOrganizationById($id)
    {
        return self::find($id);
    }


    public static function updateOrganization($id, array $data)
    {
        $Organization = self::find($id);
        if ($Organization) {
            $Organization->update($data);
            return $Organization;
        }
        return null;
    }


    public static function deleteNeed($id)
    {
        $Organization = self::find($id);
        if ($Organization) {
            $Organization->delete();
            return true;
        }
        return false;
    }



}
