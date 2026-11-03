@props(['producto'])

@php
    $paraCarrito = [
        'id' => $producto['id'],
        'marca' => $producto['marca'],
        'nombre' => $producto['nombre'],
        'precio' => $producto['precio'],
        'anterior' => $producto['precio_anterior'],
        'imagen' => $producto['imagen'] ?? null,
    ];
@endphp

{{-- Tarjeta / Producto --}}
<article {{ $attributes->merge(['class' => 'group/tarjeta flex flex-col overflow-hidden rounded-lg border border-tint-line bg-white transition-[box-shadow,border-color] duration-200 hover:border-brand/40 hover:shadow-[0_10px_28px_-12px_rgb(11_11_16/0.22)] motion-reduce:transition-none']) }}>
    <div class="relative grid h-[176px] place-items-center bg-tint">
        <x-icon name="cube" class="size-16 text-brand-soft transition-transform duration-300 group-hover/tarjeta:scale-105 motion-reduce:transition-none" stroke="1" />

        <span class="absolute top-2 left-2 grid h-6 place-items-center rounded bg-lime px-2 text-[11px] font-bold text-ink">-{{ $producto['descuento'] }}%</span>

        <button type="button" aria-label="Agregar a favoritos"
                class="absolute top-1.5 right-1.5 grid size-8 place-items-center rounded-full text-muted transition-colors hover:text-brand focus-visible:ring-2 focus-visible:ring-brand focus-visible:outline-none">
            <x-icon name="heart" class="size-[18px]" stroke="2" />
        </button>
    </div>

    <div class="flex flex-1 flex-col gap-1 px-3 pt-3 pb-3.5">
        <span class="text-[11px] font-bold tracking-wide text-brand">{{ $producto['marca'] }}</span>
        <h3 class="line-clamp-2 min-h-[2.6em] text-[13.5px] leading-[1.3] font-semibold text-ink">{{ $producto['nombre'] }}</h3>
        <p class="line-clamp-2 text-xs leading-snug text-soft">{{ $producto['descripcion'] }}</p>

        <div class="mt-1 flex items-baseline gap-2">
            <span class="text-[17px] leading-tight font-extrabold text-ink">S/ {{ number_format($producto['precio'], 2) }}</span>
            <span class="text-xs text-soft line-through">S/ {{ number_format($producto['precio_anterior'], 2) }}</span>
        </div>

        <ul class="mt-0.5 flex flex-col gap-0.5 text-[11.5px] text-graphite">
            <li class="flex items-center gap-1.5"><x-icon name="building-storefront" class="size-3.5 text-brand" stroke="2" />Retiro en tienda</li>
            <li class="flex items-center gap-1.5"><x-icon name="truck" class="size-3.5 text-brand" stroke="2" />Envío a domicilio</li>
        </ul>

        <div class="flex-1"></div>

        <button type="button" data-add-cart data-producto="{{ json_encode($paraCarrito) }}"
                class="mt-2.5 flex h-10 w-full items-center justify-center gap-2 rounded-lg bg-brand px-4 text-sm font-bold text-white transition-[background-color,transform] duration-150 hover:bg-brand-dark active:scale-[0.98] focus-visible:ring-2 focus-visible:ring-brand focus-visible:ring-offset-2 focus-visible:outline-none motion-reduce:transition-none">
            Agregar al carrito
            <x-icon name="shopping-cart" class="size-4" stroke="2" />
        </button>
    </div>
</article>
