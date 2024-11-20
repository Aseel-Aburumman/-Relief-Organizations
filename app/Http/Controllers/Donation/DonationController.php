<?php

namespace App\Http\Controllers\Donation;

use App\Http\Controllers\Controller;
use App\Http\Requests\SingleNeedRequest;
use App\Http\Requests\DonationRequest;
use App\Http\Resources\DonationResource;
use App\Models\Need;
use App\Models\Donation;


class DonationController extends Controller
{


    public function show(SingleNeedRequest $request)
    {
        $need = Need::getNeedById($request->id);

        $progress = ($need->donated_quantity / $need->quantity_needed) * 100;

        $maxDonation = $need->quantity_needed - $need->donated_quantity;

        $maxDonation = max($maxDonation, 0);

        return view('donation.donation', compact('need', 'progress','maxDonation'));
    }

    public function store(DonationRequest $request)
{
    $donation = Donation::create([
        'need_id' => $request->need_id,
        'donor_id' => auth()->id() ?? null,
        'quantity' => $request->donation_amount,
    ]);

    $need = $donation->need;
    $need->donated_quantity += $request->donation_amount;
    $need->save();

    return redirect()
    ->route('donation.show', ['id' => $request->need_id])
    ->with('success', 'Thank you for your donation! Your contribution has been recorded.');}


}
