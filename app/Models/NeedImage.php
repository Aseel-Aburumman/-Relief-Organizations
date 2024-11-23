<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NeedImage extends Model
{
    use SoftDeletes;

    use HasFactory;
    protected $table = 'needs_images';
    protected $dates = ['deleted_at'];

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


    public static function deleteNeedImage($id)
    {
        $NeedImage = self::where('need_id', $id);
        if ($NeedImage) {
            $NeedImage->delete();
            return true;
        }
        return false;
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
