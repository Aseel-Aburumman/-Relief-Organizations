<?php

namespace App\Http\Controllers\main;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Need;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use App\Models\Language;

class MainController extends Controller
{
    public function index()
    {
        $languageId = Language::getLanguageIdByLocale();


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


    public function contact()
    {
        return view('contact');
    }

    public function storeContact(ContactRequest $request): RedirectResponse
    {
        // Save contact form data to the database
        Contact::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'title' => $request->input('subject'),
            'content' => $request->input('message'),
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
}
