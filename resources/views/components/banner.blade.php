@props(['alto' => 'h-48', 'etiqueta' => 'Banner'])

{{-- Espacio reservado para la imagen del banner (fondo Tinta, icono de foto) --}}
<a href="#" {{ $attributes->merge(['class' => "grid place-items-center rounded-lg bg-tinta text-muted transition-opacity hover:opacity-90 focus-visible:ring-2 focus-visible:ring-brand focus-visible:outline-none {$alto}"]) }} aria-label="{{ $etiqueta }}">
    <x-icon name="photo" class="size-10" stroke="1.25" />
</a>
