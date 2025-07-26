<x-filament::widget>
    <x-filament::card>
        <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
            <x-heroicon-o-bell class="w-5 h-5 text-primary-600" />
            System Alerts
        </h3>

        <ul class="space-y-4">
            @forelse ($notifications as $note)
                <li class="flex items-start gap-3 p-3 rounded-lg border shadow-sm
                    @class([
                        'bg-yellow-50 border-yellow-300' => $note['type'] === 'warning',
                        'bg-red-50 border-red-300' => $note['type'] === 'danger',
                        'bg-blue-50 border-blue-300' => $note['type'] === 'info',
                        'bg-green-50 border-green-300' => $note['type'] === 'success',
                    ])
                ">
                    <x-dynamic-component
                        :component="'heroicon-o-' . ($note['icon'] ?? 'information-circle')"
                        class="w-5 h-5 text-gray-600 mt-0.5 shrink-0"
                    />

                    <div class="flex-1">
                        <p class="text-sm text-gray-800 font-medium">
                            {{ $note['message'] }}
                        </p>
                        @if (!empty($note['link']))
                            <a href="{{ $note['link'] }}"
                               class="text-sm text-primary-600 hover:underline mt-1 inline-block">
                                View details →
                            </a>
                        @endif
                    </div>
                </li>
            @empty
                <li class="text-gray-500 text-sm flex items-center gap-2">
                    <x-heroicon-o-check-circle class="w-5 h-5 text-green-600" />
                    All systems normal 🎉
                </li>
            @endforelse
        </ul>
    </x-filament::card>
</x-filament::widget>
