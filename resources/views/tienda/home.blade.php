@extends('layouts.tienda')

@section('content')
    {{-- Carrusel principal (avanza solo; se pausa al pasar el mouse, con el foco o con el botón) --}}
    <section data-carousel data-carousel-step="page" data-autoplay="5500" class="relative h-[260px] bg-brand text-white sm:h-[340px]" aria-roledescription="carrusel" aria-label="Promociones">
        <div data-carousel-track class="no-scrollbar flex h-full snap-x snap-mandatory overflow-x-auto" aria-live="off">
            @foreach (range(1, 3) as $n)
                <a href="#" class="grid h-full w-full shrink-0 snap-center place-items-center" aria-label="Promoción {{ $n }} de 3">
                    <x-icon name="photo" class="size-24 sm:size-32" stroke="0.75" />
                </a>
            @endforeach
        </div>

        <button type="button" data-carousel-prev aria-label="Anterior" class="absolute top-1/2 left-3 -translate-y-1/2 rounded-full p-1.5 transition-colors hover:bg-white/15 focus-visible:ring-2 focus-visible:ring-white focus-visible:outline-none sm:left-16">
            <x-icon name="chevron-left" class="size-7" stroke="2" />
        </button>
        <button type="button" data-carousel-next aria-label="Siguiente" class="absolute top-1/2 right-3 -translate-y-1/2 rounded-full p-1.5 transition-colors hover:bg-white/15 focus-visible:ring-2 focus-visible:ring-white focus-visible:outline-none sm:right-16">
            <x-icon name="chevron-right" class="size-7" stroke="2" />
        </button>

        <div class="absolute bottom-5 left-1/2 flex -translate-x-1/2 items-center gap-2" role="tablist" aria-label="Elegir promoción">
            @foreach (range(1, 3) as $n)
                <button type="button" data-carousel-dot role="tab" aria-label="Promoción {{ $n }}"
                        class="h-2 rounded-full bg-white transition-[width,opacity] duration-300 motion-reduce:transition-none {{ $loop->first ? 'w-6' : 'w-2 opacity-50' }}"></button>
            @endforeach
        </div>

    </section>

    {{-- Franja de beneficios --}}
    <section class="flex h-14 items-center justify-between bg-brand px-4 text-white sm:px-6" aria-label="Beneficios destacados">
        <div class="flex flex-1 items-center justify-center gap-5">
            <x-icon name="truck" class="hidden size-6 sm:block" stroke="1.75" />
            <div class="leading-tight">
                <p class="text-[15px] font-extrabold">Envío gratis</p>
                <p class="hidden text-xs sm:block">A todo el Perú en compras seleccionadas</p>
            </div>
            <a href="#" class="rounded bg-lime px-3.5 py-1.5 text-[13px] font-bold text-ink transition-[filter,transform] hover:brightness-95 active:scale-[0.98] focus-visible:ring-2 focus-visible:ring-white focus-visible:outline-none">Ver beneficios</a>
            <div class="hidden leading-tight md:block">
                <p class="text-[15px] font-extrabold">Desde S/ 199</p>
                <p class="text-xs">Aplican TyC</p>
            </div>
        </div>
    </section>

    <div class="flex flex-col gap-10 pt-8 pb-10">
        {{-- Categorías --}}
        <x-seccion titulo="Categorías" ver-todo>
            <div data-carousel data-autoplay="3500" class="relative">
                <div data-carousel-track class="no-scrollbar flex snap-x gap-3 overflow-x-auto py-1">
                    @foreach ($categorias as $categoria)
                        <a href="#" class="flex h-[124px] w-[168px] shrink-0 snap-start flex-col items-center justify-center gap-3 rounded-lg border border-tint-line bg-white p-3 text-center transition-[border-color,transform,box-shadow] duration-150 hover:border-brand hover:shadow-[0_8px_20px_-10px_rgb(255_4_0/0.35)] focus-visible:ring-2 focus-visible:ring-brand focus-visible:outline-none active:scale-[0.98] motion-reduce:transition-none">
                            <x-icon :name="$categoria['icono']" class="size-9 text-brand" stroke="1.25" />
                            <span class="text-[13.5px] font-semibold text-ink">{{ $categoria['nombre'] }}</span>
                        </a>
                    @endforeach
                </div>
                @include('tienda._flechas')
            </div>
        </x-seccion>

        {{-- Bombas de la semana --}}
        <x-seccion titulo="Bombas de la semana" ver-todo temporizador="Termina en 00 : 00 : 00">
            <div data-carousel data-autoplay="4500" class="relative">
                <div data-carousel-track class="no-scrollbar flex snap-x gap-3 overflow-x-auto">
                    @foreach ($bombas as $producto)
                        <x-tarjeta-producto :producto="$producto" class="w-[236px] shrink-0 snap-start" />
                    @endforeach
                </div>
                @include('tienda._flechas', ['arriba' => 'top-[66px]'])
            </div>
        </x-seccion>

        {{-- Banners --}}
        <section class="mx-auto grid w-full max-w-[1280px] gap-3 px-4 sm:px-6 md:grid-cols-2" aria-label="Banners">
            <x-banner alto="h-28" etiqueta="Banner 1" />
            <x-banner alto="h-28" etiqueta="Banner 2" />
        </section>
    </div>

    @include('tienda._beneficios')

    <div class="flex flex-col gap-10 py-10">
        <x-seccion titulo="¡Lo mejor en tecnología!">
            <div class="flex flex-col gap-3">
                <div class="grid gap-3 md:grid-cols-2">
                    <x-banner alto="h-44 md:h-60" etiqueta="Tecnología 1" />
                    <x-banner alto="h-44 md:h-60" etiqueta="Tecnología 2" />
                </div>
                <div class="grid gap-3 md:grid-cols-3">
                    @foreach (range(1, 3) as $n)
                        <x-banner alto="h-36 md:h-40" etiqueta="Tecnología {{ $n + 2 }}" />
                    @endforeach
                </div>
            </div>
        </x-seccion>

        <x-seccion titulo="Lo más top">
            <div class="flex flex-col gap-3">
                <x-banner alto="h-32 md:h-40" etiqueta="Top 1" />
                <div class="grid gap-3 md:grid-cols-2">
                    <x-banner alto="h-44 md:h-60" etiqueta="Top 2" />
                    <x-banner alto="h-44 md:h-60" etiqueta="Top 3" />
                </div>
            </div>
        </x-seccion>

        <x-seccion titulo="¡Un momento para ti!">
            <div class="flex flex-col gap-3">
                <x-banner alto="h-32 md:h-40" etiqueta="Momento 1" />
                <div class="grid gap-3 md:grid-cols-3">
                    @foreach (range(1, 3) as $n)
                        <x-banner alto="h-36 md:h-40" etiqueta="Momento {{ $n + 1 }}" />
                    @endforeach
                </div>
            </div>
        </x-seccion>

        <x-seccion titulo="¡Lo mejor para tu Hogar!">
            <div class="grid gap-3 md:grid-cols-2">
                <x-banner alto="h-44 md:h-60" etiqueta="Hogar 1" />
                <x-banner alto="h-44 md:h-60" etiqueta="Hogar 2" />
            </div>
        </x-seccion>

        <x-seccion titulo="Lo más vendido" ver-todo>
            <div class="grid grid-cols-2 gap-3 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                @foreach ($masVendidos as $producto)
                    <x-tarjeta-producto :producto="$producto" />
                @endforeach
            </div>
        </x-seccion>

        <x-seccion titulo="Tus últimos vistos" ver-todo>
            <div class="grid grid-cols-2 gap-3 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                @foreach ($ultimosVistos as $producto)
                    <x-tarjeta-producto :producto="$producto" />
                @endforeach
            </div>
        </x-seccion>
    </div>
@endsection
