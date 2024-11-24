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


    // public static function createRecord(array $data)
    // {
    //     return self::create($data);
    // }

    // public static function getRecordById($id)
    // {
    //     return self::find($id);
    // }

    // public static function getAllRecords()
    // {
    //     return self::all();
    // }

    // public static function updateRecord($id, array $data)
    // {
    //     $record = self::find($id);
    //     if ($record) {
    //         $record->update($data);
    //         return $record;
    //     }
    //     return null;
    // }

    // public static function deleteRecord($id)
    // {
    //     $record = self::find($id);
    //     if ($record) {
    //         $record->delete();
    //         return true;
    //     }
    //     return false;
    // }

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
