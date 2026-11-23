<div x-data="{ open: @entangle($attributes->wire('model')) }"
     x-effect="if (open) { if (!$refs.dialog.open) $refs.dialog.showModal(); } else { if ($refs.dialog.open) $refs.dialog.close(); }">
    <dialog x-ref="dialog" wire:ignore.self class="masterlist-dialog" aria-label="{{ $title }}" @close="open = false" @cancel="open = false">
        <div class="masterlist-dialog-header">
            <h2>{{ $title }}</h2>
            <button type="button" class="btn btn-sm btn-ghost btn-square" @click="open = false" aria-label="Close dialog"><i class="las la-times" aria-hidden="true"></i></button>
        </div>
        <div class="masterlist-dialog-body">{{ $slot }}</div>
        <div class="masterlist-dialog-footer">{{ $footer }}</div>
    </dialog>
</div>
