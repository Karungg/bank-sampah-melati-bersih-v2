<?php

namespace App\Observers;

use App\Contracts\NotificationServiceInterface;
use App\Models\CompanyProfile;

class CompanyProfileObserver
{
    public function __construct(protected NotificationServiceInterface $notificationService) {}
    /**
     * Handle the CompanyProfile "updated" event.
     */
    public function updated(CompanyProfile $companyProfile): void
    {
        $this->notificationService->sendUpdateNotification(
            'Profil bank sampah berhasil diupdate',
            auth()->user()->name . ' mengupdate profil bank sampah.',
            $companyProfile,
            'filament.admin.pages.company-profile',
            'name',
            'admin'
        );
    }
}
