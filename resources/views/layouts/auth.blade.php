<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') · Ciber-Max</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-canvas font-sans text-ink antialiased">
    {{-- Marcas de agua en las esquinas, como en el diseño --}}
    <div class="pointer-events-none fixed inset-0 hidden overflow-hidden md:block" aria-hidden="true">
        <x-logo size="h-24" class="absolute top-8 left-12 opacity-10 grayscale" />
        <x-logo size="h-24" class="absolute right-24 bottom-8 opacity-10 grayscale" />
    </div>

    <main class="relative flex min-h-screen flex-col items-center justify-center px-4 py-10">
        <div class="w-full max-w-80 rounded-lg bg-white px-5 py-7 shadow-[0_18px_40px_-12px_rgb(0_0_0/0.35)]">
            <a href="{{ route('home') }}" class="mx-auto mb-5 flex w-fit" aria-label="Ir a la tienda">
                <x-logo size="h-14" />
            </a>

            @yield('content')
        </div>

        <p class="mt-8 text-xs text-muted">© {{ date('Y') }} Ciber-Max — Tienda de computación</p>
    </main>
</body>
</html>
