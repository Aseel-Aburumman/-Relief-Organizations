<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    use SoftDeletes;


    protected $fillable = [
        'name',
        'language_id',



    ];
    protected $dates = ['deleted_at'];


    public function need()
    {
        return $this->hasMany(Need::class);
    }
    public function language()
    {
        return $this->belongsTo(Language::class);
    }


    public static function getAllCategories()
    {
        return self::whereNull('deleted_at')->get();
    }


    public static function getCategoryById($id)
    {
        return self::find($id);
    }

    public static function createCategory($data)
    {
        return self::create($data);
    }


    // Read (Retrieve) a single category by ID

    // Update an existing category
    public static function updateCategory($id, $data)
    {
        $category = self::find($id);
        if ($category) {
            $category->update($data);
            return $category;
        }
        return null;
    }

    // Delete (Soft delete) a category
    public static function deleteCategory($id)
    {
        $category = self::find($id);
        if ($category) {
            $category->delete();
            return true;
        }
        return false;
    }
}
