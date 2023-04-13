<button {{ $attributes->merge(['type' => 'button', 'class' => 'rounded-md px-3 py-2 text-center text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2']) }}>
    {{ $slot }}
</button>
