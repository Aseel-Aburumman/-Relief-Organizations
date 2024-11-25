<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['title', 'content', 'lang_id', 'organization_id'];

    protected $dates = ['deleted_at'];

    public function language()
    {
        return $this->belongsTo(Language::class, 'lang_id');
    }


    public function images()
    {
        return $this->hasMany(PostImage::class, 'post_id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    /**
     * Fetch paginated posts for an organization in a specific language.
     *
     * @param int $organizationId
     * @param int $languageId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function fetchPostsWithImages($organizationId, $languageId)
    {
        return self::with('images')
            ->where('organization_id', $organizationId)
            ->where('lang_id', $languageId)
            ->paginate(10);
    }

    // Static methods for CRUD
    public static function getAllPosts()
    {
        return self::all();
    }

    public static function getPostById($id)
    {
        return self::findOrFail($id);
    }

    public static function createPost(array $data)
    {
        return self::create($data);
    }

    public static function updatePost($id, array $data)
    {
        $post = self::findOrFail($id);
        $post->update($data);
        return $post;
    }

    public static function deletePost($id)
    {
        $post = self::findOrFail($id);
        $post->delete();
        return true;
    }
}
