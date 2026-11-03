@extends('layouts.auth')

@section('title', 'Iniciar sesión')

@section('content')
    <h1 class="text-center text-base font-bold">Qué bueno verte aquí</h1>
    <p class="mx-auto mt-2 max-w-[15rem] text-center text-xs leading-relaxed text-muted">
        Inicia sesión ingresando tu correo electrónico y tu contraseña para continuar.
    </p>

    <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4" novalidate>
        @csrf

        <div>
            <label for="email" class="mb-1.5 block text-xs font-semibold">Correo electrónico</label>
            <div class="relative">
                <svg class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-muted" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
                <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="admin@cibermax.com"
                       autocomplete="email" autofocus required
                       @error('email') aria-invalid="true" aria-describedby="email-error" @enderror
                       class="h-11 w-full rounded-md border bg-white pr-3 pl-9 text-xs placeholder:text-muted/80 transition-[border-color,box-shadow] duration-150 focus:border-brand focus:ring-2 focus:ring-brand/20 focus:outline-none @error('email') border-brand @else border-line @enderror">
            </div>
            @error('email')
                <p id="email-error" class="mt-1.5 text-xs text-brand-dark" role="alert">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="mb-1.5 block text-xs font-semibold">Contraseña</label>
            <div class="relative">
                <svg class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-muted" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
                <input id="password" name="password" type="password" placeholder="••••••••"
                       autocomplete="current-password" required
                       class="h-11 w-full rounded-md border border-line bg-white pr-10 pl-9 text-xs placeholder:text-muted/80 transition-[border-color,box-shadow] duration-150 focus:border-brand focus:ring-2 focus:ring-brand/20 focus:outline-none">
                <button type="button" data-toggle-password="password" aria-label="Mostrar contraseña" aria-pressed="false"
                        class="absolute top-1/2 right-1 grid size-9 -translate-y-1/2 place-items-center rounded text-muted transition-colors hover:text-ink focus-visible:ring-2 focus-visible:ring-brand focus-visible:outline-none">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
            </div>
        </div>

        <label class="flex cursor-pointer items-center gap-2 text-xs">
            <input type="checkbox" name="remember" value="1" @checked(old('remember', true))
                   class="size-3.5 rounded-sm accent-brand focus-visible:ring-2 focus-visible:ring-brand focus-visible:outline-none">
            Mantener sesión iniciada
        </label>

        <button type="submit"
                class="h-11 w-full rounded-md bg-brand text-xs font-bold text-white transition-[background-color,transform] duration-150 hover:bg-brand-dark active:scale-[0.98] focus-visible:ring-2 focus-visible:ring-brand focus-visible:ring-offset-2 focus-visible:outline-none motion-reduce:transition-none">
            Iniciar sesión
        </button>
    </form>

    @include('auth._google')

    <p class="mt-5 text-center text-xs text-muted">
        ¿Eres nuevo?
        <a href="{{ route('register') }}" class="font-semibold text-ink underline underline-offset-2 hover:text-brand">Crea tu cuenta</a>
    </p>
@endsection
