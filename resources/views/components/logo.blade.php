@props(['size' => 'h-14'])

{{-- Si existe public/images/logo.png se usa tu logo real; si no, un isotipo provisional. --}}
@if (file_exists(public_path('images/logo.png')))
    <img src="{{ asset('images/logo.png') }}" alt="Ciber-Max" {{ $attributes->merge(['class' => $size.' w-auto']) }}>
@else
    <span {{ $attributes->merge(['class' => 'inline-flex flex-col items-center leading-none select-none']) }} role="img" aria-label="Ciber-Max">
        <svg viewBox="0 0 64 40" class="{{ $size }} w-auto" aria-hidden="true">
            <text x="32" y="34" text-anchor="middle" font-family="Poppins, sans-serif" font-size="40" font-weight="800" letter-spacing="-3" fill="#ff0000">CM</text>
        </svg>
        <span class="text-[0.7rem] font-bold tracking-tight text-ink">CIBER-<span class="text-brand">MAX</span></span>
    </span>
@endif
