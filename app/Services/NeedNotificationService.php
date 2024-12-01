<?php

namespace App\Services;

use App\Mail\NeedNotificationMail;
use App\Models\Organization;
use App\Models\User;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NeedNotificationService
{
    /**
     * Send notification emails to all users about a new need.
     *
     * @param array $needDetails
     * @return void
     */
    public function notifyUsers(array $needDetails)
    {
        // Fetch all users who should receive the notification
        $organization = Organization::find($needDetails['organization_id']);
        $needDetails['organization_name'] = $organization->userDetail->first()->name ?? 'N/A';

        $users = User::all();
        Log::info('Need Details:', $needDetails);

        // Send email to each user
        foreach ($users as $user) {
            Mail::to($user->email)->send(new NeedNotificationMail($needDetails));
        }
    }
}
