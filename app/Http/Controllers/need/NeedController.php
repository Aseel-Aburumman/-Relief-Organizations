<?php

namespace App\Http\Controllers\Need;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Need;
use App\Models\Language;
use App\Models\NeedDetail;
use App\Models\NeedImage;
use App\Models\Organization;
use Illuminate\Support\Facades\App;

class NeedController extends Controller
{

    public function index(Request $request)
    {
        try {
            $languageId = Language::getLanguageIdByLocale(); 

            $needs = Need::with(['needDetail' => function ($query) use ($languageId) {
                $query->where('language_id', $languageId);
            }])->paginate(12); // تقسيم النتائج إلى صفحات

            return view('need.needs', compact('needs'));
        } catch (\Exception $e) {
            Log::error('Error fetching needs: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while fetching the needs.');
        }
    }

    /**
     * عرض التفاصيل لحاجة معينة
     */
    public function show($id)
    {
        try {
            $languageId = Language::getLanguageIdByLocale();

            $need = Need::with(['needDetail' => function ($query) use ($languageId) {
                $query->where('language_id', $languageId);
            }])->findOrFail($id);

            return view('need.show', compact('need'));
        } catch (\Exception $e) {
            Log::error('Error fetching need details: ' . $e->getMessage());
            return redirect()->route('need')->with('error', 'An error occurred while fetching the need details.');
        }
    }

    /**
     * إنشاء حاجة جديدة
     */
    public function create()
    {
        $languages = Language::all();
        $categories = Category::all();

        return view('need.create', compact('categories', 'languages'));
    }

    /**
     * حفظ حاجة جديدة
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'organization_id' => 'required|integer',
            'category_id' => 'required|integer',
            'quantity_needed' => 'required|integer',
            'urgency' => 'required|string|in:low,medium,high',
            'status' => 'required|string|in:open,closed',
        ]);

        try {
            $need = Need::create($data);

            foreach ($request->input('item_name') as $languageId => $itemName) {
                NeedDetail::create([
                    'need_id' => $need->id,
                    'language_id' => $languageId,
                    'item_name' => $itemName,
                    'description' => $request->input("description.$languageId"),
                ]);
            }

            if ($request->hasFile('image')) {
                NeedImage::uploadNeedImage($need->id, $request->file('image'));
            }

            return redirect()->route('need')->with('success', 'Need created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating Need: ' . $e->getMessage());
            return redirect()->route('need')->with('error', 'An error occurred while creating the need.');
        }
    }

    /**
     * تعديل حاجة
     */
    public function edit($id)
    {
        $need = Need::findOrFail($id);
        $needDetails = NeedDetail::where('need_id', $id)->get();
        $categories = Category::all();
        $languages = Language::all();

        return view('need.edit', compact('need', 'needDetails', 'categories', 'languages'));
    }

    /**
     * تحديث حاجة
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'category_id' => 'required|integer',
            'quantity_needed' => 'required|integer',
            'urgency' => 'required|string|in:low,medium,high',
            'status' => 'required|string|in:open,closed',
        ]);

        try {
            $need = Need::findOrFail($id);
            $need->update($data);

            foreach ($request->input('item_name') as $languageId => $itemName) {
                NeedDetail::updateOrCreate(
                    ['need_id' => $id, 'language_id' => $languageId],
                    ['item_name' => $itemName, 'description' => $request->input("description.$languageId")]
                );
            }

            if ($request->hasFile('image')) {
                NeedImage::uploadNeedImage($id, $request->file('image'));
            }

            return redirect()->route('need')->with('success', 'Need updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating Need: ' . $e->getMessage());
            return redirect()->route('need')->with('error', 'An error occurred while updating the need.');
        }
    }

    /**
     * حذف حاجة
     */
    public function destroy($id)
    {
        try {
            $need = Need::findOrFail($id);
            $need->delete();

            NeedDetail::where('need_id', $id)->delete();
            NeedImage::where('need_id', $id)->delete();

            return redirect()->route('need')->with('success', 'Need deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting Need: ' . $e->getMessage());
            return redirect()->route('need')->with('error', 'An error occurred while deleting the need.');
        }
    }
}
