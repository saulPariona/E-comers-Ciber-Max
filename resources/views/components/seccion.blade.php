@props(['titulo', 'verTodo' => false, 'temporizador' => null])

{{-- Cabecera de sección + contenido --}}
<section {{ $attributes->merge(['class' => 'mx-auto w-full max-w-[1280px] px-4 sm:px-6']) }}>
    <div class="mb-4 flex min-h-8 items-center gap-3">
        <h2 class="text-xl leading-tight font-bold tracking-tight text-ink">{{ $titulo }}</h2>

        @if ($temporizador)
            <span class="hidden items-center gap-1 rounded bg-timer-bg px-2.5 py-1 text-xs font-bold text-timer-ink tabular-nums sm:inline-flex">
                <x-icon name="clock" class="size-3.5" stroke="2" />{{ $temporizador }}
            </span>
        @endif

        <div class="flex-1"></div>

        @if ($verTodo)
            <a href="#" class="flex items-center gap-1 rounded text-[13px] font-semibold text-brand hover:underline focus-visible:ring-2 focus-visible:ring-brand focus-visible:outline-none">
                Ver todo<x-icon name="chevron-right" class="size-3.5" stroke="2.5" />
            </a>
        @endif
    </div>

    {{ $slot }}
</section>
