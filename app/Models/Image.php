<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    // الحقول القابلة للتعبئة
    protected $fillable = ['need_id', 'post_id', 'image'];

    /**
     * العلاقة مع جدول `Need`
     * تشير إلى أن الصورة مرتبطة بسجل واحد في جدول `needs`
     */
    public function need()
    {
        return $this->belongsTo(Need::class, 'need_id');
    }

    /**
     * العلاقة مع جدول `Post`
     * تشير إلى أن الصورة مرتبطة بسجل واحد في جدول `posts`
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
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
