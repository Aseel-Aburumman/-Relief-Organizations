<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    use HasFactory;
    protected $table = 'posts_images';

    // الحقول القابلة للتعبئة
    protected $fillable = ['post_id',  'image'];



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
