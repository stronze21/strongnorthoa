<div x-data="{ open: @entangle($attributes->wire('model')).defer }">
    <div x-show="open" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="p-4 bg-white rounded-lg shadow-lg w-96" @click.away="open = false">
            <h3 class="text-lg font-bold">{{ $title }}</h3>
            <div class="mt-2">
                {{ $slot }}
            </div>
            <div class="flex justify-end mt-4 space-x-2">
                {{ $footer }}
            </div>
        </div>
    </div>
</div>
