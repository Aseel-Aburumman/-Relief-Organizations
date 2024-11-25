<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationImage extends Model
{
    use HasFactory;
    use SoftDeletes;

    // الحقول القابلة للتعبئة
    protected $fillable = ['organization_id', 'image'];
    protected $table = 'organization_images';

    protected $dates = ['deleted_at'];


    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    /**
     * Fetch the first image for an organization.
     *
     * @param int $organizationId
     * @return \App\Models\OrganizationImage|null
     */
    public static function fetchFirstImage($organizationId)
    {
        return self::where('organization_id', $organizationId)->first();
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
