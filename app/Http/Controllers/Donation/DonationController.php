<?php

namespace App\Http\Controllers\Donation;

use App\Http\Controllers\Controller;
use App\Http\Requests\SingleNeedRequest;
use App\Http\Requests\DonationRequest;
use App\Models\Need;
use App\Models\Donation;

class DonationController extends Controller
{
    public function show(SingleNeedRequest $request)
    {
        $locale = session('locale', 'en');
        $languageMap = [
            'en' => 1,
            'ar' => 2,
        ];
        $languageId = $languageMap[$locale] ?? 1;

        $need = Need::where('id', $request->id)
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
        // التحقق من تسجيل الدخول
        if (!auth()->check()) {
            return redirect()
                ->route('login')
                ->with('error', 'You must be logged in to donate.');
        }

        $need = Need::findOrFail($request->need_id);

        // التحقق من أن الكمية المتبرع بها ضمن النطاق المسموح
        $remainingQuantity = $need->quantity_needed - $need->donated_quantity;
        if ($request->donation_amount > $remainingQuantity) {
            return redirect()
                ->route('donation.show', ['id' => $request->need_id])
                ->with('error', 'The donation amount exceeds the remaining quantity needed.');
        }

        // إنشاء التبرع
        $donation = Donation::create([
            'need_id' => $request->need_id,
            'donor_id' => auth()->id(),
            'quantity' => $request->donation_amount,
        ]);

        // تحديث الكمية المتبرع بها
        $need->donated_quantity += $request->donation_amount;
        $need->save();

        return redirect()
            ->route('donation.show', ['id' => $request->need_id])
            ->with('success', 'Thank you for your donation! Your contribution has been recorded.');
    }
}
