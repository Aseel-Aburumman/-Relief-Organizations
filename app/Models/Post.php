<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // الحقول القابلة للتعبئة
    protected $fillable = ['title', 'content', 'lang_id'];

    /**
     * العلاقة مع جدول `Language`
     * كل بوست مرتبط بلغة واحدة
     */
    public function language()
    {
        return $this->belongsTo(Language::class, 'lang_id');
    }

    /**
     * العلاقة مع جدول `Image`
     * لكل بوست مجموعة صور
     */
    public function images()
    {
        return $this->hasMany(Image::class, 'post_id');
    }
}
