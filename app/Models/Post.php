<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'lang_id'];


    public function language()
    {
        return $this->belongsTo(Language::class, 'lang_id');
    }


    public function images()
    {
        return $this->hasMany(Image::class, 'post_id');
    }


     public static function createRecord(array $data)
     {
         return self::create($data);
     }

     public static function getRecordById($id)
     {
         return self::find($id);
     }

     public static function getAllRecords()
     {
         return self::all();
     }

     public static function updateRecord($id, array $data)
     {
         $record = self::find($id);
         if ($record) {
             $record->update($data);
             return $record;
         }
         return null;
     }

     public static function deleteRecord($id)
     {
         $record = self::find($id);
         if ($record) {
             $record->delete();
             return true;
         }
         return false;
     }
}
