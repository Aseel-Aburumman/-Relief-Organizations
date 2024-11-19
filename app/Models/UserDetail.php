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
        'contact_info',

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
}
