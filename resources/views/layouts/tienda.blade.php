<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Ciber-Max · Tienda de computación')</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-full flex-col bg-white font-sans text-sm text-ink antialiased">
    @php
        $navegacion = \App\Support\CatalogoDemo::navegacion();
        $categoriaActiva = $categoriaActiva ?? 'Laptops';
        $usuario = auth()->user();
    @endphp

    {{-- Cabecera / Barra --}}
    <header data-header class="sticky top-0 z-40 transition-shadow duration-200">
        <div class="bg-brand text-white">
            <div class="mx-auto flex max-w-[1440px] flex-wrap items-center gap-x-8 gap-y-2.5 px-4 py-3 sm:px-8 lg:h-[68px] lg:flex-nowrap lg:py-0">
                <a href="{{ route('home') }}" class="shrink-0 rounded focus-visible:ring-2 focus-visible:ring-white focus-visible:outline-none" aria-label="Ciber-Max, inicio">
                    <x-logo size="h-12" class="[&_span]:text-white [&_text]:fill-white" />
                </a>

                <form role="search" action="{{ route('home') }}" class="order-last w-full lg:order-none lg:flex-1">
                    <label for="q" class="sr-only">Buscar productos</label>
                    <div class="flex h-11 items-center overflow-hidden rounded-lg bg-white">
                        <input id="q" name="q" type="search" value="{{ request('q') }}" placeholder="Busca laptops, impresoras, componentes y más…"
                               class="h-full min-w-0 flex-1 bg-transparent pl-4 text-sm text-ink placeholder:text-muted focus:outline-none">
                        <button type="submit" aria-label="Buscar" class="grid h-full w-12 place-items-center text-ink transition-colors hover:text-brand focus-visible:text-brand focus-visible:outline-none">
                            <x-icon name="magnifying-glass" class="size-[18px]" stroke="2" />
                        </button>
                    </div>
                </form>

                <nav class="ml-auto flex items-center gap-7" aria-label="Cuenta">
                    @auth
                        <div class="flex items-center gap-2.5">
                            <x-icon name="user" class="size-6" />
                            <div class="leading-tight">
                                <span class="block text-[11px] font-medium">Hola, {{ $usuario->Nombres }}</span>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="text-sm font-bold hover:underline">Cerrar sesión</button>
                                </form>
                            </div>
                        </div>
                        @if ($usuario->esEmpleado())
                            <a href="{{ $usuario->rutaInicio() }}" class="hidden text-sm font-bold hover:underline sm:block">Ir al panel</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="flex items-center gap-2.5 transition-opacity hover:opacity-90">
                            <x-icon name="user" class="size-6" />
                            <span class="hidden leading-tight sm:block"><span class="block text-[11px] font-medium">Hola</span><span class="block text-sm font-bold">Ingresar o registrarse</span></span>
                        </a>
                    @endauth

                    <a href="#" class="hidden items-center gap-2.5 transition-opacity hover:opacity-90 md:flex">
                        <x-icon name="heart" class="size-6" />
                        <span class="leading-tight"><span class="block text-[11px] font-medium">Mis</span><span class="block text-sm font-bold">favoritos</span></span>
                    </a>
                    <button type="button" data-cart-open aria-haspopup="dialog" aria-controls="carrito" class="flex items-center gap-2.5 rounded text-left transition-opacity hover:opacity-90 focus-visible:ring-2 focus-visible:ring-white focus-visible:outline-none">
                        <span class="relative">
                            <x-icon name="shopping-cart" class="size-6" />
                            <span data-cart-count class="absolute -top-1.5 -right-2 hidden h-4 min-w-4 place-items-center rounded-full bg-white px-1 text-[10px] leading-none font-extrabold text-brand" aria-hidden="true">0</span>
                        </span>
                        <span class="hidden leading-tight sm:block"><span class="block text-[11px] font-medium">Mi</span><span class="block text-sm font-bold">carrito</span></span>
                    </button>
                </nav>
            </div>
        </div>

        {{-- Menú --}}
        <nav class="border-b border-border bg-white" aria-label="Categorías">
            <div class="mx-auto flex h-12 max-w-[1440px] items-center gap-8 px-4 sm:px-8">
                <button type="button" data-menu-open aria-haspopup="dialog" aria-controls="menu-categorias"
                        class="flex shrink-0 items-center gap-2 rounded-md py-1.5 pr-1 text-sm font-bold text-brand focus-visible:ring-2 focus-visible:ring-brand focus-visible:outline-none">
                    <x-icon name="bars-3" class="size-5 text-ink" stroke="2" />
                    Todas las categorías
                    <x-icon name="chevron-down" class="size-3.5" stroke="2.5" />
                </button>
                <ul class="no-scrollbar flex min-w-0 flex-1 items-center justify-between gap-6 overflow-x-auto whitespace-nowrap">
                    @foreach ($navegacion as $categoria)
                        @php($activa = $categoria['nombre'] === $categoriaActiva)
                        <li>
                            <a href="#" @class([
                                'flex items-center gap-1.5 rounded-md py-1.5 text-sm transition-colors hover:text-brand focus-visible:ring-2 focus-visible:ring-brand focus-visible:outline-none',
                                'font-bold text-brand' => $activa,
                                'font-semibold text-ink' => ! $activa,
                            ])>
                                <x-icon :name="$categoria['icono']" :class="['size-[18px]', 'text-brand' => $activa, 'text-graphite' => ! $activa]" stroke="1.75" />
                                {{ $categoria['nombre'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </nav>
    </header>

    <x-menu-categorias />
    <x-carrito />

    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Pie --}}
    <footer class="bg-brand text-white">
        <div class="mx-auto grid max-w-[1440px] gap-10 px-4 pt-10 pb-7 sm:grid-cols-2 sm:px-8 lg:grid-cols-[340px_1fr_1fr_1fr]">
            <div class="flex flex-col gap-3">
                <x-logo size="h-14" class="self-start [&_span]:text-white [&_text]:fill-white" />
                <p class="max-w-[300px] text-[13px] leading-relaxed">Tu tienda de tecnología: laptops, impresoras, componentes y accesorios con atención personalizada.</p>
            </div>

            @foreach ([
                'Servicio al cliente' => ['Centro de ayuda', 'Políticas de devolución y cambio', 'Términos y condiciones', 'Libro de reclamaciones'],
                'Compra segura' => ['Métodos de pago', 'Envíos y entregas', 'Garantía de productos', 'Seguimiento de pedido'],
            ] as $titulo => $enlaces)
                <div class="flex flex-col gap-2.5">
                    <h2 class="text-sm font-bold">{{ $titulo }}</h2>
                    @foreach ($enlaces as $enlace)
                        <a href="#" class="w-fit text-[13px] hover:underline">{{ $enlace }}</a>
                    @endforeach
                </div>
            @endforeach

            <div class="flex flex-col gap-2.5">
                <h2 class="text-sm font-bold">Contáctanos</h2>
                @foreach ([['phone', 'Teléfono de contacto'], ['envelope', 'correo@cibermax.pe'], ['map-pin', 'Dirección de la tienda'], ['clock', 'Horario de atención']] as [$icono, $texto])
                    <a href="#" class="flex w-fit items-center gap-2 text-[13px] hover:underline">
                        <x-icon :name="$icono" class="size-4 shrink-0" />{{ $texto }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="border-t border-white/90">
            <div class="mx-auto flex max-w-[1440px] flex-wrap items-center justify-between gap-2 px-4 py-3.5 text-xs sm:px-8">
                <span>© {{ date('Y') }} Ciber-Max. Todos los derechos reservados.</span>
                <span class="flex items-center gap-2"><x-icon name="lock-closed" class="size-3.5" />Pagos seguros con tarjeta, transferencia y billeteras digitales</span>
            </div>
        </div>
    </footer>
</body>
</html>
