import './carrito';

const reducirMovimiento = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const comportamiento = reducirMovimiento ? 'auto' : 'smooth';

// Mostrar / ocultar contraseña
document.querySelectorAll('[data-toggle-password]').forEach((boton) => {
    const campo = document.getElementById(boton.dataset.togglePassword);
    if (!campo) return;

    boton.addEventListener('click', () => {
        const visible = campo.type === 'text';
        campo.type = visible ? 'password' : 'text';
        boton.setAttribute('aria-pressed', String(!visible));
        boton.setAttribute('aria-label', visible ? 'Mostrar contraseña' : 'Ocultar contraseña');
    });
});

// Carruseles: [data-carousel] > [data-carousel-track], con flechas, puntos y avance automático opcionales.
//  - data-carousel-step="page" avanza una pantalla completa; por defecto, una tarjeta.
//  - data-autoplay="ms" avanza solo y vuelve al inicio al llegar al final. Se pausa con el mouse,
//    el foco, si la pestaña no está visible o con el botón [data-carousel-toggle]. No corre si el
//    usuario pidió reducir el movimiento.
document.querySelectorAll('[data-carousel]').forEach((raiz) => {
    const pista = raiz.querySelector('[data-carousel-track]');
    if (!pista) return;

    const porPagina = raiz.dataset.carouselStep === 'page';
    const paso = () => {
        if (porPagina) return pista.clientWidth;
        const primera = pista.firstElementChild;
        const hueco = parseFloat(getComputedStyle(pista).columnGap) || 0;
        return primera ? primera.getBoundingClientRect().width + hueco : pista.clientWidth;
    };
    const alFinal = () => pista.scrollLeft + pista.clientWidth >= pista.scrollWidth - 2;

    const retroceder = () => pista.scrollBy({ left: -paso(), behavior: comportamiento });
    const avanzar = () => (alFinal() ? pista.scrollTo({ left: 0, behavior: comportamiento }) : pista.scrollBy({ left: paso(), behavior: comportamiento }));

    raiz.querySelector('[data-carousel-prev]')?.addEventListener('click', retroceder);
    raiz.querySelector('[data-carousel-next]')?.addEventListener('click', avanzar);

    // Puntos indicadores
    const puntos = [...raiz.querySelectorAll('[data-carousel-dot]')];
    if (puntos.length) {
        const marcar = (indice) => puntos.forEach((punto, i) => {
            const activo = i === indice;
            punto.classList.toggle('w-6', activo);
            punto.classList.toggle('w-2', !activo);
            punto.classList.toggle('opacity-50', !activo);
            punto.setAttribute('aria-selected', String(activo));
        });

        pista.addEventListener('scroll', () => marcar(Math.round(pista.scrollLeft / pista.clientWidth)), { passive: true });
        puntos.forEach((punto, i) => punto.addEventListener('click', () => pista.scrollTo({ left: i * pista.clientWidth, behavior: comportamiento })));
        marcar(0);
    }

    // Avance automático
    const intervalo = parseInt(raiz.dataset.autoplay, 10);
    if (!intervalo || reducirMovimiento) {
        raiz.querySelector('[data-carousel-toggle]')?.remove();
        return;
    }

    let encima = false;
    let conFoco = false;
    let detenido = false; // decidido por el usuario con el botón

    setInterval(() => {
        const sePuedeMover = pista.scrollWidth > pista.clientWidth + 2;
        if (!encima && !conFoco && !detenido && !document.hidden && sePuedeMover) avanzar();
    }, intervalo);

    raiz.addEventListener('mouseenter', () => (encima = true));
    raiz.addEventListener('mouseleave', () => (encima = false));
    raiz.addEventListener('focusin', () => (conFoco = true));
    raiz.addEventListener('focusout', () => (conFoco = false));

    const alternar = raiz.querySelector('[data-carousel-toggle]');
    alternar?.addEventListener('click', () => {
        detenido = !detenido;
        alternar.setAttribute('aria-pressed', String(detenido));
        alternar.setAttribute('aria-label', detenido ? 'Reanudar carrusel' : 'Pausar carrusel');
        alternar.querySelector('[data-icon-pause]')?.classList.toggle('hidden', detenido);
        alternar.querySelector('[data-icon-play]')?.classList.toggle('hidden', !detenido);
    });
});

// Menú lateral "Todas las categorías" (<dialog>)
const menu = document.getElementById('menu-categorias');
if (menu) {
    const abrir = document.querySelectorAll('[data-menu-open]');
    const items = [...menu.querySelectorAll('[data-menu-item]')];
    const paneles = [...menu.querySelectorAll('[data-menu-panel]')];

    const activar = (indice) => {
        items.forEach((item) => item.setAttribute('data-active', String(item.dataset.menuItem === indice)));
        paneles.forEach((panel) => panel.setAttribute('data-active', String(panel.dataset.menuPanel === indice)));
    };

    items.forEach((item) => {
        item.addEventListener('mouseenter', () => activar(item.dataset.menuItem));
        item.addEventListener('focus', () => activar(item.dataset.menuItem));
    });

    abrir.forEach((boton) => boton.addEventListener('click', () => {
        menu.showModal();
        document.documentElement.classList.add('overflow-hidden');
    }));

    menu.querySelectorAll('[data-menu-close]').forEach((boton) => boton.addEventListener('click', () => menu.close()));
    // Clic fuera de los paneles (sobre el fondo del diálogo) cierra el menú
    menu.addEventListener('click', (evento) => {
        if (evento.target === menu || evento.target === menu.firstElementChild) menu.close();
    });
    menu.addEventListener('close', () => document.documentElement.classList.remove('overflow-hidden'));
}

// Cabecera fija: aparece una sombra suave cuando la página ya se desplazó
const cabecera = document.querySelector('[data-header]');
if (cabecera) {
    const sombra = () => cabecera.classList.toggle('shadow-[0_6px_18px_-8px_rgb(11_11_16/0.35)]', window.scrollY > 4);
    window.addEventListener('scroll', sombra, { passive: true });
    sombra();
}
