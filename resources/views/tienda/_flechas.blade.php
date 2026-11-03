{{-- Flechas de carrusel (círculo blanco 44 px, borde y sombra del diseño) --}}
@php($arriba = $arriba ?? 'top-1/2 -translate-y-1/2')
@foreach ([['prev', 'chevron-left', 'Anterior', '-left-[22px]'], ['next', 'chevron-right', 'Siguiente', '-right-[22px]']] as [$accion, $icono, $texto, $posicion])
    <button type="button" data-carousel-{{ $accion }} aria-label="{{ $texto }}"
            class="absolute {{ $arriba }} z-10 hidden size-11 place-items-center rounded-full border border-border bg-white text-ink shadow-[0_4px_12px_rgb(11_11_16/0.12)] transition-[transform,border-color] duration-150 hover:border-brand active:scale-95 focus-visible:ring-2 focus-visible:ring-brand focus-visible:outline-none motion-reduce:transition-none xl:grid {{ $posicion }}">
        <x-icon :name="$icono" class="size-5" stroke="2" />
    </button>
@endforeach
