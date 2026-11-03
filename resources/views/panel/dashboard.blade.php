<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $area }} · Ciber-Max</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-canvas font-sans text-ink antialiased">
    @php($usuario = auth()->user())

    <header class="bg-brand text-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3 sm:px-6">
            <div class="flex items-center gap-4">
                <x-logo size="h-9" class="[&_span]:text-white [&_text]:fill-white" />
                <span class="text-sm font-bold">Panel · {{ $area }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="rounded-md border border-white/40 px-3 py-1.5 text-xs font-bold transition-colors hover:bg-white hover:text-brand focus-visible:ring-2 focus-visible:ring-white focus-visible:outline-none">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-10 sm:px-6">
        <h1 class="text-xl font-bold">Hola, {{ $usuario->Nombres }}</h1>
        <p class="mt-1 text-sm text-muted">{{ $usuario->rol->Nombre }} · {{ $usuario->CodigoUsuario }}</p>
    </main>
</body>
</html>
