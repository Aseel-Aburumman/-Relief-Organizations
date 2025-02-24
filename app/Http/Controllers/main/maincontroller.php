<?php

namespace App\Http\Controllers\main;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Need;
use App\Models\Post;
use App\Models\User;
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
        $organizationsCount = Organization::count();
        $postsCount = Post::count();
        $fullyDonatedNeedsCount = Need::whereColumn('quantity_needed', 'donated_quantity')->count();
        $usersCount = User::count();




        // جلب المنظمات مع userDetail والصور
        $organizations = Organization::with(['userDetail', 'image'])->take(3)->get();

        // جلب الاحتياجات مع التفاصيل المرتبطة باللغة واسم الحاجة


        $needs = Need::fetchNeedswithoutsEARCH($languageId);


        // جلب المنشورات مع الصور المرتبطة
        $posts = Post::with('images')->take(3)->get();

        // تمرير البيانات إلى العرض
        return view('index', compact('organizations', 'needs', 'posts', 'organizationsCount', 'postsCount', 'fullyDonatedNeedsCount', 'usersCount'));
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
