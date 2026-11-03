@extends('layouts.auth')

@section('title', 'Crear cuenta')

@php
    $campo = 'h-11 w-full rounded-md border bg-white px-3 text-xs placeholder:text-muted/80 transition-[border-color,box-shadow] duration-150 focus:border-brand focus:ring-2 focus:ring-brand/20 focus:outline-none';
@endphp

@section('content')
    <h1 class="text-center text-base font-bold">Crea tu cuenta</h1>
    <p class="mx-auto mt-2 max-w-[16rem] text-center text-xs leading-relaxed text-muted">
        Regístrate para comprar, guardar favoritos y seguir tus pedidos.
    </p>

    <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4" novalidate>
        @csrf

        <div class="grid grid-cols-[6.5rem_1fr] gap-3">
            <div>
                <label for="TipoDocumento" class="mb-1.5 block text-xs font-semibold">Documento</label>
                <select id="TipoDocumento" name="TipoDocumento" class="{{ $campo }} @error('TipoDocumento') border-brand @else border-line @enderror">
                    @foreach (['DNI', 'CE', 'PASAPORTE'] as $tipo)
                        <option value="{{ $tipo }}" @selected(old('TipoDocumento', 'DNI') === $tipo)>{{ $tipo }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="NumeroDocumento" class="mb-1.5 block text-xs font-semibold">Número</label>
                <input id="NumeroDocumento" name="NumeroDocumento" type="text" inputmode="numeric" value="{{ old('NumeroDocumento') }}"
                       required class="{{ $campo }} @error('NumeroDocumento') border-brand @else border-line @enderror">
            </div>
        </div>
        @foreach (['TipoDocumento', 'NumeroDocumento'] as $n)
            @error($n)<p class="-mt-2 text-xs text-brand-dark" role="alert">{{ $message }}</p>@enderror
        @endforeach

        @foreach ([['Nombres', 'Nombres', 'text', 'given-name'], ['Apellidos', 'Apellidos', 'text', 'family-name'], ['Telefono', 'Teléfono (opcional)', 'tel', 'tel'], ['Email', 'Correo electrónico', 'email', 'email']] as [$name, $label, $type, $auto])
            <div>
                <label for="{{ $name }}" class="mb-1.5 block text-xs font-semibold">{{ $label }}</label>
                <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ old($name) }}" autocomplete="{{ $auto }}"
                       @if ($name !== 'Telefono') required @endif
                       class="{{ $campo }} @error($name) border-brand @else border-line @enderror">
                @error($name)<p class="mt-1.5 text-xs text-brand-dark" role="alert">{{ $message }}</p>@enderror
            </div>
        @endforeach

        <div>
            <label for="Password" class="mb-1.5 block text-xs font-semibold">Contraseña</label>
            <div class="relative">
                <input id="Password" name="Password" type="password" autocomplete="new-password" required
                       class="{{ $campo }} pr-10 @error('Password') border-brand @else border-line @enderror">
                <button type="button" data-toggle-password="Password" aria-label="Mostrar contraseña" aria-pressed="false"
                        class="absolute top-1/2 right-1 grid size-9 -translate-y-1/2 place-items-center rounded text-muted transition-colors hover:text-ink focus-visible:ring-2 focus-visible:ring-brand focus-visible:outline-none">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
            </div>
            @error('Password')<p class="mt-1.5 text-xs text-brand-dark" role="alert">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="Password_confirmation" class="mb-1.5 block text-xs font-semibold">Repite la contraseña</label>
            <input id="Password_confirmation" name="Password_confirmation" type="password" autocomplete="new-password" required
                   class="{{ $campo }} border-line">
        </div>

        <button type="submit"
                class="h-11 w-full rounded-md bg-brand text-xs font-bold text-white transition-[background-color,transform] duration-150 hover:bg-brand-dark active:scale-[0.98] focus-visible:ring-2 focus-visible:ring-brand focus-visible:ring-offset-2 focus-visible:outline-none motion-reduce:transition-none">
            Crear cuenta
        </button>
    </form>

    @include('auth._google')

    <p class="mt-5 text-center text-xs text-muted">
        ¿Ya tienes cuenta?
        <a href="{{ route('login') }}" class="font-semibold text-ink underline underline-offset-2 hover:text-brand">Inicia sesión</a>
    </p>
@endsection
