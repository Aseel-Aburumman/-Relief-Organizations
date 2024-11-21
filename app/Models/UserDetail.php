<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'user_detailes';


    protected $fillable = [
        'name',
        'organization_id',
        'description',
        'language_id',
        'address',
        'user_id',
    ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public static function getAllUserDetails()
    {
        return self::all();
    }

    public static function createUserDetail(array $data)
    {
        return self::create($data);
    }

    public function updateUserDetail(array $data)
    {
        return $this->update($data);
    }

    public function deleteUserDetail()
    {
        return $this->delete();
    }

    public static function findUserDetailById(int $id)
    {
        return self::find($id);
    }

    public static function createMultipleUserDetails(array $details): void
    {
        foreach ($details as $detail) {
            self::create($detail);
        }
    }
}
