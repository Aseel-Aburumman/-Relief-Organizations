<?php

namespace App\Models;


use Carbon\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NeedDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'needDetails';

    protected $fillable = [
        'need_id',
        'item_name',
        'language_id',
        'description',
    ];

    protected $dates = ['deleted_at'];

    public function need()
    {
        return $this->belongsTo(Need::class);
    }

    public function language()
    {
        return $this->belongsTo(\App\Models\Language::class, 'language_id');
    }



    /**
     * Create NeedDetails for a Need.
     *
     * @param int $needId
     * @param array $details
     * @return void
     */
    public static function createNeedDetailsWithLang($needId, array $details)
    {
        foreach ($details['item_name'] as $languageCode => $itemName) {
            self::create([
                'need_id' => $needId,
                'item_name' => $itemName,
                'description' => $details['description'][$languageCode] ?? '',
                'language_id' => \App\Models\Language::where('key', $languageCode)->first()->id,
            ]);
        }
    }



    // CRUD Methods
    public static function createMultipleNeedDetails(array $details): void
    {
        foreach ($details as $detail) {
            self::create($detail);
        }
    }

    public static function createNeedDetail(array $data)
    {
        return self::create($data);
    }


    public static function getAllNeedDetails()
    {
        return self::all();
    }


    public static function getNeedDetailById($id)
    {
        return self::find($id);
    }


    /**
     * Update or Create Need Details for a Need.
     *
     * @param int $needId
     * @param array $details
     * @return void
     */
    public static function updateNeedDetails($needId, array $details)
    {
        foreach ($details['item_name'] as $languageCode => $itemName) {
            $languageId = \App\Models\Language::where('key', $languageCode)->first()->id;

            $detail = self::where('need_id', $needId)->where('language_id', $languageId)->first();

            if ($detail) {
                $detail->update([
                    'item_name' => $itemName,
                    'description' => $details['description'][$languageCode] ?? '',
                ]);
            } else {
                self::create([
                    'need_id' => $needId,
                    'item_name' => $itemName,
                    'description' => $details['description'][$languageCode] ?? '',
                    'language_id' => $languageId,
                ]);
            }
        }
    }


    public static function deleteNeedDetail($id)
    {
        $NeedDetail = self::where('need_id', $id);
        if ($NeedDetail) {
            $NeedDetail->delete();
            return true;
        }
        return false;
    }


    public static function restoreNeedDetail($id)
    {
        return self::withTrashed()->where('id', $id)->restore();
    }


    public static function forceDeleteNeedDetail($id)
    {
        $NeedDetail = self::withTrashed()->find($id);
        if ($NeedDetail) {
            $NeedDetail->forceDelete();
            return true;
        }
        return false;
    }
}
