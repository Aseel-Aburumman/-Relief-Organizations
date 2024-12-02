<?php

namespace App\Http\Controllers\Donation;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\DonationRequest;
use App\Http\Resources\DonationResource;
use App\Models\Need;
use App\Models\Organization;

use App\Models\User;
use App\Models\Language;
use App\Models\Donation;
use Illuminate\Http\Request;
use App\Events\DonationUpdated;

class DonationController extends Controller
{
    public function show($id)
    {
        $locale = session('locale', 'en');
        $languageMap = [
            'en' => 1,
            'ar' => 2,
        ];
        $languageId = $languageMap[$locale] ?? 1;

        $need = Need::where('id', $id)
            ->with(['needDetail' => function ($query) use ($languageId) {
                $query->orderByRaw("FIELD(language_id, ?, 1, 2)", [$languageId]);
            }])
            ->first();

        if (!$need) {
            abort(404, 'Need not found');
        }

        $progress = ($need->donated_quantity / $need->quantity_needed) * 100;
        $maxDonation = max($need->quantity_needed - $need->donated_quantity, 0);

        session()->put('redirect_need_id', $id);

        return view('donation.donation', compact('need', 'progress', 'maxDonation'));
    }


    public function store(Request $request)
    {
        if (!auth()->check()) {
            session()->put('redirect_after_login', url()->current());

            return redirect()->route('login')->with('error', __('You need to log in to make a donation.'));
        }

        $request->validate([
            'need_id' => 'required|exists:needs,id',
            'donation_amount' => 'required|integer|min:1',
        ]);

        $need = Need::findOrFail($request->need_id);

        $remainingQuantity = $need->quantity_needed - $need->donated_quantity;
        if ($request->donation_amount > $remainingQuantity) {
            if ($request->ajax()) {
                return response()->json([
                    'error' => __('The donation amount exceeds the remaining quantity.'),
                ], 422);
            }
            return redirect()->back()->withErrors([
                'donation_amount' => __('The donation amount exceeds the remaining quantity.'),
            ]);
        }

        $donation = Donation::create([
            'need_id' => $need->id,
            'donor_id' => auth()->id(),
            'quantity' => $request->donation_amount,
        ]);
        event(new DonationUpdated($donation, 'created'));
        // $need->increment('donated_quantity', $request->donation_amount);

        // if ($need->donated_quantity >= $need->quantity_needed) {
        //     $need->update(['status' => 'Fulfilled']);
        // }

        // if ($request->ajax()) {
        //     return new DonationResource($donation);
        // }

        return redirect()->route('donation.show', $need->id)
            ->with('success', __('Thank you for your donation!'));
    }




    public function listDonations(Request $request)
    {
        try {
            $user = Auth::user();
            $user = User::find($user->id);

            $search = $request->input('search');
            $languageId = Language::getLanguageIdByLocale();

            if ($user->hasRole('admin')) {
                $donations = Donation::fetchDonationsWithDetails($search, $languageId);
            } elseif ($user->hasRole('organization')) {
                $organization = Organization::fetchOrganizationWithNeedsAndDonations($user->id);
                $donations = Donation::fetchOrganizationDonationsWithDetails($search, $organization->id, $languageId);
            }

            return view('dashboard.donations.manage_donations', compact('donations'));
        } catch (\Exception $e) {
            Log::error('Error fetching donations: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while fetching the donations. Please try again.');
        }
    }


    public function showDonation($id)
    {
        $donation = new DonationResource(Donation::with(['user.userDetail', 'need.needDetail'])->findOrFail($id));

        return view('dashboard.donations.show_donation', compact('donation'));
    }

    public function showEditForm($id)
    {
        $donation = Donation::findOrFail($id);
        $needs = Need::all();
        $donors = User::with('userDetail')->get();

        return view('dashboard.donations.edit_donation', compact('donation', 'needs', 'donors'));
    }

    public function updateDonation(DonationRequest $request, $id)
    {
        $validatedData = $request->validated();
        $donation = Donation::findOrFail($id);
        $previousQuantity = $donation->quantity;
        $donation->update([
            'need_id' => $validatedData['need_id'],

            'quantity' => $validatedData['quantity'],
        ]);
        // dd($previousQuantity);

        event(new DonationUpdated($donation, 'updated', $previousQuantity));

        // $need = $donation->need;
        // $need->donated_quantity = $need->donated_quantity - $previousQuantity + $validatedData['quantity'];
        // $need->save();

        return redirect()
            ->route('donations.index')
            ->with('success', 'Donation updated successfully.');
    }

    public function deleteDonation($id)
    {
        $donation = Donation::findOrFail($id);
        event(new DonationUpdated($donation, 'deleted'));

        $donation->delete();

        return redirect()
            ->route('donations.index')
            ->with('success', 'Donation deleted successfully.');
    }
}
