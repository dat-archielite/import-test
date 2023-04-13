<x-app-layout>
    <div x-data="products" class="max-w-4xl mx-auto mt-6 mb-8 px-4 space-y-6">
        <div>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Products') }}</h1>
                    <p class="mt-2 text-sm text-gray-700">{!! __('You can manage your products here. Total: :total products', ['total' => '<span class="font-bold" x-text="formatNumber(total)"></span>']) !!}</p>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none space-x-2">
                    <x-button x-on:click="$dispatch('open-modal', 'import-product')" class="bg-blue-600 text-white hover:bg-blue-500 focus-visible:outline-blue-600">{{ __('Import Product') }}</x-button>
                    <x-button x-on:click="$dispatch('open-modal', 'truncate-products')" class="bg-red-600 text-white hover:bg-red-500 focus-visible:outline-red-600">{{ __('Truncate Products') }}</x-button>
                </div>
                @include('partials.import-modal')
                @include('partials.truncate-modal')
            </div>
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                        {{ __('SKU') }}
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        {{ __('Price') }}
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        {{ __('Stock') }}
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        {{ __('Status') }}
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                <template
                                    x-for="product in products.data"
                                    :key="product.id"
                                >
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6" x-text="product.sku"></td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500" x-text="formatPrice(product.price)"></td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500" x-text="formatNumber(product.stock)"></td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <x-badge x-bind:class="{ 'bg-gray-100 text-gray-800': product.status === 'drafted', 'bg-green-100 text-green-800': product.status === 'published' }" x-text="product.status"></x-badge>
                                        </td>
                                    </tr>
                                </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
