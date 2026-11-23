<x-slot name="header"><nav class="text-sm breadcrumbs" aria-label="Breadcrumb"><ul><li aria-current="page">QR Codes</li></ul></nav></x-slot>

<div class="qr-page">
    <style>
        .qr-page { max-width: 1480px; margin: auto; padding: 22px 24px 40px; color: #263247; }
        .qr-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; margin-bottom: 20px; }
        .qr-header h1 { font-size: 27px; font-weight: 700; line-height: 1.3; margin-bottom: 5px; }
        .qr-header p { color: #607087; font-size: 14px; }
        .qr-toolbar { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 18px; }
        .qr-page .input { height: 40px; min-height: 40px; border: 1px solid #cbd5e1; border-radius: 8px; background: white; color: #263247; font-size: 14px; }
        .qr-search { width: 320px; max-width: 100%; }
        .qr-count { color: #607087; font-size: 13px; }
        .qr-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 18px; }
        .qr-card { background: white; border-radius: 12px; min-width: 0; overflow: hidden; }
        .qr-card-body { padding: 20px; }
        .qr-preview { display: flex; align-items: center; justify-content: center; padding: 12px 0 22px; }
        .qr-preview img { width: 180px; height: 180px; object-fit: contain; }
        .qr-card h2 { font-size: 17px; font-weight: 700; overflow-wrap: anywhere; line-height: 1.4; margin-bottom: 8px; }
        .qr-content { color: #526078; font-size: 13px; line-height: 1.7; overflow-wrap: anywhere; white-space: pre-wrap; max-height: 110px; overflow-y: auto; }
        .qr-created { color: #607087; font-size: 12px; margin-top: 14px; }
        .qr-card-footer { padding: 14px 20px; border-top: 1px solid #edf0f4; display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: wrap; }
        .qr-card-footer > span { color: #607087; font-size: 12px; }
        .qr-downloads { display: flex; gap: 8px; }
        .qr-empty { grid-column: 1 / -1; text-align: center; padding: 48px 20px; background: white; border-radius: 12px; }
        .qr-empty h2 { font-size: 19px; font-weight: 700; margin-bottom: 8px; }
        .qr-empty p { font-size: 14px; color: #607087; margin-bottom: 16px; }
        .qr-page .masterlist-dialog { width: min(500px, calc(100vw - 32px)); max-height: calc(100dvh - 40px); padding: 0; border: 0; border-radius: 14px; background: white; color: #263247; box-shadow: 0 24px 70px rgba(15,23,42,.24); }
        .qr-page .masterlist-dialog::backdrop { background: rgba(15,23,42,.55); }
        .qr-page .masterlist-dialog-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 20px 24px; border-bottom: 1px solid #e5e7eb; }
        .qr-page .masterlist-dialog h2 { font-size: 21px; font-weight: 700; }
        .qr-page .masterlist-dialog-body { padding: 24px; }
        .qr-page .masterlist-dialog-footer { padding: 16px 24px; display: flex; justify-content: flex-end; gap: 10px; background: #f8fafc; border-top: 1px solid #e5e7eb; }
        .qr-page .qr-label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px; }
        .qr-page textarea { background: white; width: 100%; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; }
        .qr-help { font-size: 12px; color: #607087; margin-top: 7px; line-height: 1.6; }
        .qr-error { font-size: 12px; color: #b91c1c; margin-top: 6px; }
        .qr-page a:focus-visible, .qr-page button:focus-visible, .qr-page input:focus-visible, .qr-page textarea:focus-visible { outline: 2px solid #4338ca; outline-offset: 3px; }
        @media(max-width: 1000px) { .qr-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
        @media(max-width: 640px) { .qr-page { padding: 18px 12px 28px; } .qr-grid { grid-template-columns: minmax(0, 1fr); } .qr-search { width: 100%; } }
    </style>
    <header class="qr-header"><div><h1>QR Codes</h1><p>Create codes for links or text and download them as images.</p></div><button type="button" class="btn btn-sm btn-primary" wire:click="openCreate"><i class="las la-plus" aria-hidden="true"></i> Create QR Code</button></header>
    <div class="qr-toolbar"><input type="search" class="input qr-search" placeholder="Search title or content…" aria-label="Search QR codes" wire:model.debounce.300ms="search"><span class="qr-count" aria-live="polite">{{ number_format($qrs->total()) }} QR codes <span wire:loading wire:target="search">· Searching…</span></span></div>
    <div class="qr-grid">
        @forelse($qrs as $qr)
            <article class="qr-card" wire:key="qr-{{ $qr->id }}" x-data="{ busy: false, message: '' }">
                <div class="qr-card-body">
                    <div class="qr-preview"><img id="qr-image-{{ $qr->id }}" src="data:image/svg+xml;base64,{{ base64_encode(QrCode::format('svg')->size(1024)->margin(4)->eyeColor(2, 237, 41, 57, 225, 48, 57)->style('dot')->eye('circle')->generate($qr->code)) }}" width="180" height="180" alt="QR code for {{ $qr->title }}"></div>
                    <h2>{{ $qr->title }}</h2><p class="qr-content">{{ $qr->content }}</p><p class="qr-created">Created {{ $qr->created_at ? $qr->created_at->format('M j, Y · g:i A') : 'date unavailable' }}</p>
                </div>
                <footer class="qr-card-footer"><span>1024 × 1024 px</span><div class="qr-downloads">
                    @foreach(['png' => 'PNG', 'jpeg' => 'JPG'] as $format => $label)
                        <button type="button" class="btn btn-sm btn-outline" :disabled="busy" data-image-id="qr-image-{{ $qr->id }}" data-filename="{{ \Illuminate\Support\Str::slug($qr->title) ?: 'qr-code' }}-{{ $qr->id }}" @click="busy = true; message = ''; try { await downloadQrImage($el.dataset.imageId, $el.dataset.filename, '{{ $format }}'); message = '{{ $label }} downloaded'; } catch (error) { message = 'Download failed. Please try again.'; } finally { busy = false; }"><i class="las la-download" aria-hidden="true"></i> {{ $label }}</button>
                    @endforeach
                </div><span class="qr-help" x-text="message" role="status"></span></footer>
            </article>
        @empty
            <div class="qr-empty"><h2>{{ $search ? 'No matching QR codes' : 'No QR codes yet' }}</h2><p>{{ $search ? 'Try another title or content.' : 'Create a code to share a link or text.' }}</p>@if($search)<button type="button" class="btn btn-sm btn-outline" wire:click="$set('search', '')">Clear search</button>@else<button type="button" class="btn btn-sm btn-primary" wire:click="openCreate">Create QR Code</button>@endif</div>
        @endforelse
    </div>
    <div class="mt-5">{{ $qrs->links() }}</div>
    <x-modal wire:model="showCreate">
        <x-slot name="title">Create QR code</x-slot>
        <div><label class="qr-label" for="qr-title">Title</label><input id="qr-title" class="input w-full" type="text" maxlength="255" wire:model.defer="title" @error('title') aria-invalid="true" @enderror>@error('title')<p class="qr-error" role="alert">{{ $message }}</p>@enderror</div>
        <div class="mt-5"><label class="qr-label" for="qr-content">Content or link</label><textarea id="qr-content" class="textarea" rows="4" wire:model.defer="content" aria-describedby="qr-content-help" @error('content') aria-invalid="true" @enderror></textarea><p id="qr-content-help" class="qr-help">For a website, include the full address starting with https://.</p>@error('content')<p class="qr-error" role="alert">{{ $message }}</p>@enderror</div>
        <x-slot name="footer"><button type="button" class="btn btn-sm btn-outline" wire:click="$set('showCreate', false)" wire:loading.attr="disabled" wire:target="save">Cancel</button><button type="button" class="btn btn-sm btn-primary" wire:click="save" wire:loading.attr="disabled" wire:target="save"><span wire:loading.remove wire:target="save">Create QR code</span><span wire:loading wire:target="save">Creating…</span></button></x-slot>
    </x-modal>
</div>

@push('scripts')
<script>
    async function downloadQrImage(imageId, filename, format) {
        if (!['png', 'jpeg'].includes(format)) throw new Error('Unsupported format');
        const source = document.getElementById(imageId);
        if (!source) throw new Error('QR image not found');
        const loadedImage = new Image();
        const ready = new Promise((resolve, reject) => { loadedImage.onload = resolve; loadedImage.onerror = reject; });
        loadedImage.src = source.src;
        await ready;
        const canvas = document.createElement('canvas');
        canvas.width = canvas.height = 1024;
        const context = canvas.getContext('2d');
        if (!context) throw new Error('Image conversion unavailable');
        context.fillStyle = '#ffffff';
        context.fillRect(0, 0, 1024, 1024);
        context.drawImage(loadedImage, 0, 0, 1024, 1024);
        const blob = await new Promise(resolve => canvas.toBlob(resolve, 'image/' + format, 0.98));
        if (!blob) throw new Error('Image conversion failed');
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = filename + (format === 'jpeg' ? '.jpg' : '.png');
        document.body.appendChild(link);
        link.click();
        link.remove();
        setTimeout(() => URL.revokeObjectURL(url), 1000);
    }
</script>
@endpush
