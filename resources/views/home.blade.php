<x-app-layout>
    <div x-data="products" class="max-w-4xl mx-auto mt-6 mb-8 px-4 space-y-6">
        <div class="p-4 px-6 bg-white rounded-xl shadow">
            <h3 class="flex items-center gap-2 text-lg font-semibold">
                <x-icons.arrow-up-tray class="w-5 h-5" />
                {{ __('Import Product') }}
            </h3>
            <p class="mt-1 text-sm text-gray-600">{{ __('Import product by upload CSV file.') }}</p>
            <div class="mt-4">
                <input type="file" class="filepond" accept="text/csv" />
            </div>
        </div>
        <div class="p-4 px-6 bg-white rounded-xl shadow">
            <template
                x-for="product in products.data"
                :key="product.id"
            >
                <p x-text="product.name"></p>
            </template>
        </div>
    </div>
</x-app-layout>
