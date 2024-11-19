<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDetail extends Model
{
    use HasFactory;
    use SoftDeletes;



    protected $fillable = [
        'name',
        'organization_id',
        'description',
        'language_id',
        'contact_info',

        'user_id',
    ];
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function language()
    {
        return $this->hasMany(Language::class);
    }
    public function organization()
    {
        return $this->hasMany(Organization::class);
    }
}
