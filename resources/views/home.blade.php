<x-app-layout>
    <div class="max-w-4xl mx-auto my-8">
        <div class="p-4 px-6 bg-white rounded-xl shadow">
            <h3 class="flex items-center gap-2 text-lg font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                </svg>
                {{ __('Import Product') }}
            </h3>
            <p class="mt-1 text-sm text-gray-600">{{ __('Import product by upload CSV file.') }}</p>
            <div class="mt-4">
                <input type="file" class="filepond" accept="text/csv" />
            </div>
        </div>
    </div>
</x-app-layout>
