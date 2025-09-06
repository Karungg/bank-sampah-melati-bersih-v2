<x-filament-panels::page>
    <form wire:submit='edit'>
        {{ $this->form }}

        {{ $this->editAction }}
    </form>
</x-filament-panels::page>
