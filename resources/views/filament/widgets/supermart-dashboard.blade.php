@php
    $sections = ['Sales', 'Inventory', 'Customers'];
@endphp

<div x-data="dashboardToggle()" x-init="loadState()" class="space-y-4">

    {{-- Toggle Controls --}}
    <div class="flex flex-wrap gap-2">
        @foreach ($sections as $section)
            <label class="inline-flex items-center space-x-2">
                <input type="checkbox" x-model="visibleSections['{{ $section }}']" @change="saveState()" class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500">
                <span>{{ $section }}</span>
            </label>
        @endforeach
    </div>

    {{-- Sales Section --}}
    <div x-show="visibleSections['Sales']" x-transition>
        @livewire('widgets.sales-overview')
        @livewire('widgets.monthly-revenue-chart')
    </div>

    {{-- Inventory Section --}}
    <div x-show="visibleSections['Inventory']" x-transition>
        @livewire('widgets.top-products-sold')
        @livewire('widgets.low-stock-products')
    </div>

    {{-- Customers Section --}}
    <div x-show="visibleSections['Customers']" x-transition>
        @livewire('widgets.customer-growth-trend')
        @livewire('widgets.cashier-performance')
    </div>

</div>

<script>
    function dashboardToggle() {
        return {
            visibleSections: {
                Sales: true,
                Inventory: true,
                Customers: true,
            },
            saveState() {
                localStorage.setItem('dashboardVisibility', JSON.stringify(this.visibleSections));
            },
            loadState() {
                const stored = localStorage.getItem('dashboardVisibility');
                if (stored) {
                    this.visibleSections = JSON.parse(stored);
                }
            }
        }
    }
</script>
