<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NeedImage extends Model
{
    use HasFactory;
    protected $table = 'needs_images';

    // الحقول القابلة للتعبئة
    protected $fillable = ['need_id', 'image'];

    /**
     * العلاقة مع جدول `Need`
     * تشير إلى أن الصورة مرتبطة بسجل واحد في جدول `needs`
     */
    public function need()
    {
        return $this->belongsTo(Need::class, 'need_id');
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
