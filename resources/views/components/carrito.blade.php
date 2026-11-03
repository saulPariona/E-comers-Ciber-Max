{{-- Carrito: panel lateral derecho (<dialog> modal). La lógica está en resources/js/carrito.js --}}
<dialog id="carrito" class="carrito m-0 h-dvh max-h-none w-full max-w-none overflow-hidden bg-transparent p-0 text-ink" aria-labelledby="carrito-titulo">
    <div class="ml-auto flex h-full w-full flex-col bg-white shadow-[-12px_0_32px_rgb(11_11_16/0.25)] sm:w-[400px]">
        {{-- Cabecera --}}
        <header class="flex h-[60px] shrink-0 items-center gap-2 bg-brand px-3 text-white">
            <button type="button" data-cart-close aria-label="Cerrar carrito" autofocus
                    class="grid size-10 place-items-center rounded-lg transition-colors hover:bg-white/15 focus-visible:ring-2 focus-visible:ring-white focus-visible:outline-none">
                <x-icon name="x-mark" class="size-[22px]" stroke="2" />
            </button>
            <h2 id="carrito-titulo" class="flex flex-1 items-baseline gap-1 text-[17px] font-extrabold">
                Carrito <span class="font-medium text-white/85" data-cart-total-items>(0)</span>
            </h2>
            <button type="button" data-cart-clear
                    class="flex h-8 items-center gap-1 rounded-lg border border-white px-3 text-xs font-semibold transition-colors hover:bg-white hover:text-brand focus-visible:ring-2 focus-visible:ring-white focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50">
                <x-icon name="trash" class="size-3.5" stroke="2" />Limpiar carrito
            </button>
        </header>

        {{-- Lista --}}
        <div class="relative flex-1 overflow-y-auto bg-lista">
            <ul data-cart-list class="flex flex-col gap-2 p-3"></ul>

            <div data-cart-empty class="absolute inset-0 hidden flex-col items-center justify-center gap-3 p-6 text-center">
                <x-icon name="shopping-cart" class="size-14 text-muted" stroke="1.25" />
                <p class="text-sm text-soft">Tu carrito está vacío</p>
            </div>
        </div>

        {{-- Totales y pago --}}
        <footer class="flex shrink-0 flex-col gap-3 border-t border-border bg-white px-4 pt-4 pb-5">
            <dl class="flex flex-col gap-0.5">
                <div class="flex items-center justify-between">
                    <dt class="text-[15px] font-extrabold">Total:</dt>
                    <dd class="text-[15px] font-extrabold text-brand tabular-nums" data-cart-total>S/ 0.00</dd>
                </div>
                <div class="flex items-center justify-between text-[13px] text-soft">
                    <dt>Ahorraste:</dt>
                    <dd class="tabular-nums" data-cart-saved>S/ 0.00</dd>
                </div>
            </dl>

            <button type="button" data-cart-pay
                    class="flex h-10 items-center justify-center gap-2 rounded-lg bg-brand text-sm font-bold text-white transition-[background-color,transform] duration-150 hover:bg-brand-dark active:scale-[0.98] focus-visible:ring-2 focus-visible:ring-brand focus-visible:ring-offset-2 focus-visible:outline-none disabled:pointer-events-none disabled:bg-brand/35 motion-reduce:transition-none">
                <x-icon name="lock-closed" class="size-3.5" stroke="2" />Ir a pagar
            </button>

            <button type="button" data-cart-close class="mx-auto rounded text-[13px] font-semibold text-brand hover:underline focus-visible:ring-2 focus-visible:ring-brand focus-visible:outline-none">
                Seguir comprando
            </button>
        </footer>

        <p class="sr-only" role="status" aria-live="polite" data-cart-status></p>
    </div>

    {{-- Plantilla de cada producto del carrito --}}
    <template id="carrito-item">
        <li class="flex items-start gap-3 rounded-lg bg-white p-3 shadow-[0_1px_3px_rgb(11_11_16/0.08)]">
            {{-- Imagen del producto (si no hay foto, el cubo de marcador) --}}
            <div class="grid size-24 shrink-0 place-items-center overflow-hidden rounded-lg bg-tint">
                <img data-f="imagen" alt="" class="hidden size-full object-contain">
                <x-icon name="cube" class="size-11 text-brand-soft" stroke="1" data-f="marcador" />
            </div>

            <div class="flex min-w-0 flex-1 flex-col">
                <span class="text-[15px] leading-tight font-bold text-ink" data-f="marca"></span>
                <span class="mt-0.5 text-[13px] leading-snug text-graphite" data-f="nombre"></span>
                <div class="mt-1 flex flex-wrap items-baseline gap-x-2">
                    <span class="text-[15px] leading-tight font-extrabold text-brand tabular-nums" data-f="precio"></span>
                    <span class="text-xs text-soft line-through tabular-nums" data-f="anterior"></span>
                </div>

                <div class="mt-2.5 flex h-9 w-full items-center justify-between rounded-full border border-brand bg-white" role="group" aria-label="Cantidad">
                    <button type="button" data-action="menos" aria-label="Quitar una unidad"
                            class="grid h-full w-11 place-items-center rounded-l-full text-brand transition-colors hover:bg-tint focus-visible:ring-2 focus-visible:ring-brand focus-visible:outline-none disabled:pointer-events-none disabled:opacity-40">
                        <x-icon name="minus" class="size-4" stroke="2.25" />
                    </button>
                    <span class="text-sm font-semibold text-ink tabular-nums" data-f="cantidad" aria-live="polite"></span>
                    <button type="button" data-action="mas" aria-label="Agregar una unidad"
                            class="grid h-full w-11 place-items-center rounded-r-full text-brand transition-colors hover:bg-tint focus-visible:ring-2 focus-visible:ring-brand focus-visible:outline-none">
                        <x-icon name="plus" class="size-4" stroke="2.25" />
                    </button>
                </div>
            </div>

            <button type="button" data-action="eliminar" aria-label="Eliminar producto"
                    class="grid size-9 shrink-0 place-items-center rounded-lg border border-border bg-white text-ink transition-colors hover:border-brand hover:text-brand focus-visible:ring-2 focus-visible:ring-brand focus-visible:outline-none">
                <x-icon name="trash" class="size-[18px]" stroke="1.75" />
            </button>
        </li>
    </template>
</dialog>
