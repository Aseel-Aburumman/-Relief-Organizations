<?php

namespace App\Http\Controllers\Donation;

use App\Http\Controllers\Controller;
use App\Http\Requests\DonationRequest;
use App\Http\Resources\DonationResource;
use App\Models\Need;
use App\Models\User;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function show(DonationRequest $request)
    {
        $locale = session('locale', 'en');
        $languageMap = [
            'en' => 1,
            'ar' => 2,
        ];
        $languageId = $languageMap[$locale] ?? 1;

        $need = Need::where('id', $request->need_id)
            ->with(['needDetail' => function ($query) use ($languageId) {
                $query->orderByRaw("FIELD(language_id, ?, 1, 2)", [$languageId]);
            }])
            ->firstOrFail();

        $progress = ($need->donated_quantity / $need->quantity_needed) * 100;
        $maxDonation = max($need->quantity_needed - $need->donated_quantity, 0);

        return view('donation.donation', compact('need', 'progress', 'maxDonation'));
    }

    public function store(DonationRequest $request)
    {
        $validatedData = $request->validated();

        $need = Need::findOrFail($validatedData['need_id']);

        $donation = Donation::create([
            'need_id' => $validatedData['need_id'],
            'donor_id' => auth()->id(),
            'quantity' => $validatedData['donation_amount'],
        ]);

        $need->donated_quantity += $validatedData['donation_amount'];
        $need->save();

        return redirect()
            ->route('donation.show', ['id' => $validatedData['need_id']])
            ->with('success', 'Thank you for your donation! Your contribution has been recorded.');
    }

    public function listDonations()
    {
        $donations = DonationResource::collection(Donation::with(['user.userDetail', 'need.needDetail'])->get());

        return view('dashboard.donations.manage_donations', compact('donations'));
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
            'donor_id' => $validatedData['donor_id'],
            'quantity' => $validatedData['quantity'],
        ]);

        $need = $donation->need;
        $need->donated_quantity = $need->donated_quantity - $previousQuantity + $validatedData['quantity'];
        $need->save();

        return redirect()
            ->route('donations.index')
            ->with('success', 'Donation updated successfully.');
    }

    public function deleteDonation($id)
    {
        $donation = Donation::findOrFail($id);
        $donation->delete();

        return redirect()
            ->route('donations.index')
            ->with('success', 'Donation deleted successfully.');
    }
}
