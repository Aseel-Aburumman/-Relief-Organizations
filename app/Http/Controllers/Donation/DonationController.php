<?php

namespace App\Http\Controllers\Donation;

use App\Http\Controllers\Controller;
use App\Http\Requests\DonationRequest;
use App\Http\Resources\DonationResource;
use App\Models\Need;
use App\Models\User;
use App\Models\Donation;

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
        $maxDonation = $need->quantity_needed - $need->donated_quantity;
        $maxDonation = max($maxDonation, 0);

        return view('donation.donation', compact('need', 'progress', 'maxDonation'));
    }

    public function store(DonationRequest $request)
    {
        if (!auth()->check()) {
            return redirect()
                ->route('login')
                ->with('error', 'You must be logged in to donate.');
        }

        $need = Need::findOrFail($request->need_id);

        $donation = Donation::create([
            'need_id' => $request->need_id,
            'donor_id' => auth()->id(),
            'quantity' => $request->donation_amount,
        ]);

        $need->donated_quantity += $request->donation_amount;
        $need->save();

        return redirect()
            ->route('donation.show', ['id' => $request->need_id])
            ->with('success', 'Thank you for your donation! Your contribution has been recorded.');
    }

}
