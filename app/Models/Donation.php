<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'need_id',
        'donor_id',
        'quantity',

    ];

    protected $dates = ['deleted_at'];

    public function need()
    {
        return $this->belongsTo(Need::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'donor_id');
    }



    public static function getAllDonations()
    {
        return self::whereNull('deleted_at')->get();
    }


    public static function getDonationById($id)
    {
        return self::find($id);
    }

    
    public static function createDonation($data)
    {
        return self::create($data);
    }


    // Update an existing donation
    public static function updateDonation($id, $data)
    {
        $donation = self::find($id);
        if ($donation) {
            $donation->update($data);
            return $donation;
        }
        return null;
    }

    // Delete (Soft delete) a donation
    public static function deleteDonation($id)
    {
        $donation = self::find($id);
        if ($donation) {
            $donation->delete();
            return true;
        }
        return false;
    }

}

