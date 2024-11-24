<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['title', 'content', 'name', 'email'];

    protected $dates = ['deleted_at'];



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
