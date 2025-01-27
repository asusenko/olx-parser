<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Дашборд') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium">Підписка на посилання</h3>
                    <ul>
                        @forelse ($links as $link)
                            <li>
                                <a href="{{ $link->url_link }}" target="_blank" class="text-blue-500 underline">
                                    {{ $link->url_link }}
                                </a>
                                <span class="text-sm text-gray-500">Last Price: {{ $link->last_price }}</span>
                            </li>
                        @empty
                            <li class="text-gray-500">Ще поки немає посилань</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
