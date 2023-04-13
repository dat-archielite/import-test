<x-modal name="import-product">
    <h3 class="flex items-center gap-2 text-lg font-semibold">
        <x-icons.arrow-up-tray class="w-5 h-5" />
        {{ __('Import Product') }}
    </h3>
    <p class="mt-1 text-sm text-gray-600">{{ __('Import product by upload CSV file.') }}</p>
    <div class="mt-4">
        <input type="file" class="filepond" accept="text/csv" />
    </div>
</x-modal>
