{{-- Barra "Beneficios": fondo Tinte rojo con borde --}}
<section class="border-y border-tint-line bg-tint" aria-label="Beneficios de comprar en Ciber-Max">
    <ul class="mx-auto flex min-h-12 max-w-[1440px] flex-wrap items-center justify-center gap-x-10 gap-y-2 px-4 py-2.5">
        @foreach ($beneficios as $beneficio)
            <li class="flex items-center gap-2 text-[13px] font-semibold text-ink">
                <x-icon :name="$beneficio['icono']" class="size-5 text-brand" stroke="1.75" />{{ $beneficio['texto'] }}
            </li>
        @endforeach
    </ul>
</section>
