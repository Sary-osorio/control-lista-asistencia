<div
    x-data="{ activeTab: null }"
    x-init="activeTab = {{ $default ?? 1 }}"
    class="w-full"
    x-cloak
>

    <!-- Encabezados -->
    <div class="flex border-b justify-center">
        @foreach ($tabs as $index => $tab)
            <button
                @click="activeTab = {{ $index + 1 }}"
                class="px-10 py-2 pb-2 border-b-2 transition-colors"
                :class="activeTab === {{ $index + 1 }}
                    ? 'border-blue-600 text-blue-600 font-semibold'
                    : 'border-transparent text-gray-600'">
                {{ $tab }}
            </button>
        @endforeach
    </div>

    <!-- Contenido -->
    <div class="mt-4">
        {{ $slot }}
    </div>

</div>
