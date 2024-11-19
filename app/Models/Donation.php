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
        'amount',

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
}
