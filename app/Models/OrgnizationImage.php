<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrgnizationImage extends Model
{
    use HasFactory;
    use SoftDeletes;

    // الحقول القابلة للتعبئة
    protected $fillable = ['orgnization_id', 'image'];
    protected $table = 'orgnization_images';

    protected $dates = ['deleted_at'];


    public function orgnization()
    {
        return $this->belongsTo(Organization::class, 'orgnization_id');
    }


    /**
     * إرجاع المسار الكامل للصورة
     * إذا كنت تستخدم التخزين في مجلد `storage`
     */
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image);
    }
}
