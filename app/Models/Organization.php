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
        'certificate_image',
        'status',

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
        return $this->hasMany(OrganizationImage::class);
    }

    public function post()
    {
        return $this->hasMany(Post::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function donations()
    {
        return $this->hasMany(Donation::class);
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



    /**
     * Fetch an organization with its needs and donations by user ID.
     *
     * @param int $userId
     * @return \App\Models\Organization|null
     */
    public static function fetchOrganizationWithNeedsAndDonations($userId)
    {
        return self::with(['needs.donations'])
            ->where('user_id', $userId)
            ->first();
    }


    /**
     * Fetch an organization with user details ordered by language.
     *
     * @param int $id
     * @param int $languageId
     * @return \App\Models\Organization|null
     */
    public static function fetchOrganizationWithUserDetails($id, $languageId)
    {
        return self::with(['userDetail' => function ($query) use ($languageId) {
            $query->orderByRaw("FIELD(language_id, ?, 1, 2)", [$languageId]);
        }])->find($id);
    }
}
