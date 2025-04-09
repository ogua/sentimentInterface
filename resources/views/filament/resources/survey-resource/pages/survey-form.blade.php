<x-filament-panels::page>
    <div>
    <form wire:submit.prevent="submit" class="space-y-6">

        <x-filament::section>
            {{ $this->form }}
        </x-filament::section>

        {{-- <x-filament::button type="submit">
            Submit Survey
        </x-filament::button> --}}
    </form>
    <x-filament-actions::modals />
</div>
</x-filament-panels::page>
