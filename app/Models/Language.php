<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'key',
        'name',
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

    public function category()
    {
        return $this->hasMany(Category::class);
    }


    
}
