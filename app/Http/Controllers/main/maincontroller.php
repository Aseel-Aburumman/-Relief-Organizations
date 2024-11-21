<?php
namespace App\Http\Controllers\main;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Need;
use App\Models\Post;

class MainController extends Controller
{
    public function index()
    {
        // جلب المنظمات مع userDetail والصور
        $organizations = Organization::with(['userDetail', 'image'])->take(3)->get();

        // جلب 3 عناصر من جدول needs
        $needs = Need::take(3)->get();

        // جلب البيانات من جدول posts مع الصور المرتبطة
        $posts = Post::with('images')->take(3)->get();

        // تمرير البيانات إلى العرض
        return view('index', compact('organizations', 'needs', 'posts'));
    }
}

