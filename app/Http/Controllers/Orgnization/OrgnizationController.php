<?php

namespace App\Http\Controllers\Orgnization;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Need;
use App\Models\Category;
use App\Models\Language;

use App\Models\NeedDetail;
use Illuminate\Support\Facades\App;

use App\Models\NeedImage;
use App\Http\Requests\NeedRequest;

use Illuminate\Http\Request;

use App\Models\Donation;

class OrgnizationController extends Controller
{


    public function dashboard()
    {
        // dd(auth()->id());
        $organization = Organization::with(['need.donations'])->where('user_id', auth()->id())->first();
        // dd($organization);
        if (!$organization) {
            return redirect()->back()->with('error', 'No organization found for the logged-in user.');
        }
        $needs = $organization->need;
        $totalDonatedQuantity = $needs->sum('donated_quantity');
        $totalDonations = Donation::whereIn('need_id', function ($query) use ($organization) {
            $query->select('id')
                ->from('needs')
                ->where('organization_id', $organization->id);
        })->count();

        return view('dashboard.organization_dashboard', compact('organization', 'needs', 'totalDonatedQuantity', 'totalDonations'));
    }

    public function getOne($id)
    {
        $locale = session('locale', 'en');
        $languageMap = [
            'en' => 1, // English language_id
            'ar' => 2, // Arabic language_id
        ];

        $languageId = $languageMap[$locale] ?? 1;

        $organization = Organization::getOrganizationById($id)
            ->with(['userDetail' => function ($query) use ($languageId) {
                $query->orderByRaw("FIELD(language_id, ?, 1, 2)", [$languageId]);
            }])
            ->get();

        dd($organization);

        return view('organization.organization_profile', compact('organization'));
    }
}
