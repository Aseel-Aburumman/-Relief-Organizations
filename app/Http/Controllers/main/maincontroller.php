<?php
namespace App\Http\Controllers\main;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Need;
use App\Models\Post;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        // تحديد اللغة النشطة بناءً على الجلسة (session)
        $locale = session('locale', 'en');
        $languageMap = [
            'en' => 1, // English language_id
            'ar' => 2, // Arabic language_id
        ];
        $languageId = $languageMap[$locale] ?? 1;

        // جلب المنظمات مع userDetail والصور
        $organizations = Organization::with(['userDetail', 'image'])->take(3)->get();

        // جلب الاحتياجات مع التفاصيل المرتبطة باللغة واسم الحاجة
        $needs = Need::with(['needDetail' => function ($query) use ($languageId) {
            $query->where('language_id', $languageId)
                  ->select('id', 'need_id', 'item_name', 'description'); // جلب الحقول المطلوبة فقط
        }])->take(3)->get();

        // جلب المنشورات مع الصور المرتبطة
        $posts = Post::with('images')->take(3)->get();

        // تمرير البيانات إلى العرض
        return view('index', compact('organizations', 'needs', 'posts'));
    }
}




