@props(['name', 'variant' => 'outline', 'stroke' => null])

{{-- Heroicons (resources/svg/heroicons/{outline|solid}/{name}.svg). Uso: <x-icon name="heart" class="size-5" /> --}}
@php
    // Permite :class="['size-5', 'text-brand' => $activo]"
    if (is_array($attributes->get('class'))) {
        $attributes = new \Illuminate\View\ComponentAttributeBag([
            ...$attributes->getAttributes(),
            'class' => \Illuminate\Support\Arr::toCssClasses($attributes->get('class')),
        ]);
    }

    $archivo = resource_path("svg/heroicons/{$variant}/{$name}.svg");
    $svg = is_file($archivo) ? file_get_contents($archivo) : null;

    $svg = $svg ? str_replace([' aria-hidden="true"', ' data-slot="icon"'], '', $svg) : null;

    if ($svg && $stroke) {
        $svg = str_replace('stroke-width="1.5"', 'stroke-width="'.$stroke.'"', $svg);
    }
@endphp
@if ($svg)
    {!! preg_replace('/<svg\b/', '<svg '.$attributes->merge(['aria-hidden' => 'true']), $svg, 1) !!}
@endif
