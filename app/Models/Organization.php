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
        'name',
        'name_ar',

        'email',
        'password',
        'logo',
        'description',
        'description_ar',

        'contact_info',
        'contact_info_ar',


    ];

    protected $dates = ['deleted_at'];

    public function need()
    {
        return $this->hasMany(Need::class);
    }

}
