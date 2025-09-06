<x-filament-panels::page>
    <form wire:submit='updateProfile'>
        {{ $this->editProfileForm }}

        {{ $this->getUpdateProfileFormActions }}
    </form>

    <form wire:submit='updatePassword'>
        {{ $this->editPasswordForm }}

        {{ $this->getUpdatePasswordFormActions }}
    </form>
</x-filament-panels::page>
