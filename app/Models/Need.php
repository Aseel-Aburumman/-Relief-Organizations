<?php

namespace App\Models;

use Carbon\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Need extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'organization_id',
        'category_id',
        'item_name',
        'language_id',
        'quantity_needed',
        'donated_quantity',
        'description',
        'urgency',
        'status',



    ];

    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }



    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
    public function language()
    {
        return $this->belongsTo(Language::class);
    }
    public function image()
    {
        return $this->hasMany(Image::class);
    }


    // CRUD Methods


    public static function createNeed(array $data)
    {
        return self::create($data);
    }


    public static function getAllNeeds()
    {
        return self::all();
    }

    public static function getNeedById($id)
    {
        return self::findOrFail($id); 
    }



    public static function updateNeed($id, array $data)
    {
        $need = self::find($id);
        if ($need) {
            $need->update($data);
            return $need;
        }
        return null;
    }


    public static function deleteNeed($id)
    {
        $need = self::find($id);
        if ($need) {
            $need->delete();
            return true;
        }
        return false;
    }


    public static function restoreNeed($id)
    {
        return self::withTrashed()->where('id', $id)->restore();
    }


    public static function forceDeleteNeed($id)
    {
        $need = self::withTrashed()->find($id);
        if ($need) {
            $need->forceDelete();
            return true;
        }
        return false;
    }
}
