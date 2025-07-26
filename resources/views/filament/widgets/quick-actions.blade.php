<!-- quick-actions.blade.php -->
<x-filament::widget>
    <x-filament::card class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <x-filament::button tag="a" href="{{ route('filament.admin.resources.sales.create') }}">
            <x-slot name="icon">
                <x-heroicon-o-plus-circle class="w-5 h-5" />
            </x-slot>
            Add Sale
        </x-filament::button>

        <x-filament::button tag="a" href="{{ route('filament.admin.resources.products.index') }}">
            <x-slot name="icon">
                <x-heroicon-o-archive-box class="w-5 h-5" />
            </x-slot>
            Restock Product
        </x-filament::button>

        <x-filament::button tag="a" href="{{ route('filament.admin.resources.customers.create') }}">
            <x-slot name="icon">
                <x-heroicon-o-user-plus class="w-5 h-5" />
            </x-slot>
            Add Customer
        </x-filament::button>

        <x-filament::button tag="a" href="{{ route('filament.admin.resources.sales.index', ['tableFilters[today]' => true]) }}">
            <x-slot name="icon">
                <x-heroicon-o-clock class="w-5 h-5" />
            </x-slot>
            Today’s Sales
        </x-filament::button>
    </x-filament::card>
</x-filament::widget>
