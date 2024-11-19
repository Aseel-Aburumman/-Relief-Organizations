<?php

namespace App\Models;

use Carbon\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Need extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'organization_id',
        'category_id',
        'item_name',
        'language_id',
        'quantity_needed',
        'donated_quantity',
        'description',
        'urgency',
        'status',



    ];

    protected $dates = ['deleted_at']; 

    public function category(){
        return $this->belongsTo(Category::class);
    }
    
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
    public function language()
    {
        return $this->belongsTo(Language::class);
    }
    public function image()
    {
        return $this->hasMany(Image::class);
    }

}
