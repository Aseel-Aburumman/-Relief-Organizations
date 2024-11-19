<?php

namespace App\Models;

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
        'quantity_needed',
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

}
