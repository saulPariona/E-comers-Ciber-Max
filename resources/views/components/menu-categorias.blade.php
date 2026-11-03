@php
    $menu = \App\Support\CatalogoDemo::menu();
    $usuario = auth()->user();
@endphp

{{-- Menú lateral "Todas las categorías". <dialog> modal: foco atrapado, Esc cierra y el fondo queda inerte. --}}
<dialog id="menu-categorias" class="menu-categorias m-0 h-dvh max-h-none w-full max-w-none overflow-hidden bg-transparent p-0 text-ink" aria-labelledby="menu-saludo">
    <div class="flex h-full">
        {{-- Lista de categorías --}}
        <aside class="flex h-full w-full flex-col bg-white shadow-[6px_0_24px_rgb(11_11_16/0.18)] sm:w-[400px] sm:shrink-0">
            <div class="flex h-16 shrink-0 items-center gap-3 bg-brand pr-5 pl-6 text-white">
                <x-icon name="user" class="size-[22px]" stroke="2" />
                <p id="menu-saludo" class="text-[17px] font-extrabold">
                    @auth ¡Hola, {{ $usuario->Nombres }} @else <a href="{{ route('login') }}" class="hover:underline">¡Hola! Inicia sesión</a> @endauth
                </p>
                <div class="flex-1"></div>
                <button type="button" data-menu-close autofocus aria-label="Cerrar menú"
                        class="grid size-10 place-items-center rounded-lg transition-colors hover:bg-white/15 focus-visible:ring-2 focus-visible:ring-white focus-visible:outline-none">
                    <x-icon name="x-mark" class="size-[22px]" stroke="2" />
                </button>
            </div>

            <nav class="flex-1 overflow-y-auto p-3" aria-label="Todas las categorías">
                <ul class="flex flex-col gap-0.5">
                    @foreach ($menu as $i => $categoria)
                        <li>
                            <a href="#" data-menu-item="{{ $i }}" data-active="{{ $i === 0 ? 'true' : 'false' }}"
                               class="group flex h-12 items-center gap-3.5 rounded-lg pr-3 pl-3.5 text-[15px] font-medium text-ink transition-colors hover:bg-tint focus-visible:ring-2 focus-visible:ring-brand focus-visible:outline-none data-[active=true]:bg-tint data-[active=true]:font-bold data-[active=true]:text-brand">
                                <x-icon :name="$categoria['icono']" class="size-5 shrink-0 text-graphite group-data-[active=true]:text-brand" stroke="1.75" />
                                <span class="flex-1">{{ $categoria['nombre'] }}</span>
                                <x-icon name="chevron-right" class="size-4 text-soft group-data-[active=true]:text-brand" stroke="2.25" />
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </aside>

        {{-- Subcategorías (solo en pantallas grandes) --}}
        <section class="mt-16 hidden max-w-[636px] flex-1 overflow-y-auto rounded-tr-2xl bg-white p-8 lg:block" aria-label="Subcategorías">
            @foreach ($menu as $i => $categoria)
                <div data-menu-panel="{{ $i }}" data-active="{{ $i === 0 ? 'true' : 'false' }}" class="hidden data-[active=true]:block">
                    <div class="flex items-center justify-between gap-4">
                        <h2 class="relative pb-2 text-xl font-extrabold tracking-tight text-ink uppercase after:absolute after:inset-x-0 after:bottom-0 after:h-[3px] after:rounded-sm after:bg-brand">{{ $categoria['nombre'] }}</h2>
                        <a href="#" class="flex shrink-0 items-center gap-2 rounded-lg bg-brand px-4 py-2 text-sm font-bold text-white transition-[background-color,transform] duration-150 hover:bg-brand-dark active:scale-[0.98] focus-visible:ring-2 focus-visible:ring-brand focus-visible:ring-offset-2 focus-visible:outline-none">
                            Ver todo<x-icon name="arrow-right" class="size-4" stroke="2.25" />
                        </a>
                    </div>

                    <div class="mt-7 columns-2 gap-8">
                        @foreach ($categoria['grupos'] as $titulo => $enlaces)
                            <div class="mb-6 break-inside-avoid">
                                <h3 class="mb-2 text-[15px] font-bold text-ink">{{ $titulo }}</h3>
                                <ul class="flex flex-col gap-1.5">
                                    @foreach ($enlaces as $enlace)
                                        <li><a href="#" class="text-[13px] text-graphite transition-colors hover:text-brand hover:underline focus-visible:text-brand focus-visible:outline-none">{{ $enlace }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </section>
    </div>
</dialog>
