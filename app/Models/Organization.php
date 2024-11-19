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
}
