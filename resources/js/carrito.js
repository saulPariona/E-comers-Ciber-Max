// Carrito de compras (solo frontend): el estado vive en localStorage y se comparte entre pestañas.
const CLAVE = 'cibermax.carrito';

const dialogo = document.getElementById('carrito');
if (dialogo) {
    const lista = dialogo.querySelector('[data-cart-list]');
    const vacio = dialogo.querySelector('[data-cart-empty]');
    const plantilla = document.getElementById('carrito-item');
    const estado = dialogo.querySelector('[data-cart-status]');
    const botonPagar = dialogo.querySelector('[data-cart-pay]');
    const botonLimpiar = dialogo.querySelector('[data-cart-clear]');

    const dinero = new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    const formato = (n) => `S/ ${dinero.format(n)}`;

    const leer = () => {
        try {
            const datos = JSON.parse(localStorage.getItem(CLAVE) || '[]');
            return Array.isArray(datos) ? datos : [];
        } catch {
            return [];
        }
    };
    const guardar = (items) => {
        try { localStorage.setItem(CLAVE, JSON.stringify(items)); } catch { /* modo privado: queda solo en pantalla */ }
    };

    let items = leer();

    const anunciar = (texto) => { estado.textContent = ''; requestAnimationFrame(() => (estado.textContent = texto)); };

    const pintar = () => {
        const unidades = items.reduce((suma, i) => suma + i.cantidad, 0);
        const total = items.reduce((suma, i) => suma + i.precio * i.cantidad, 0);
        const ahorro = items.reduce((suma, i) => suma + Math.max(0, i.anterior - i.precio) * i.cantidad, 0);

        // Contador del encabezado y del icono del carrito
        dialogo.querySelector('[data-cart-total-items]').textContent = `(${unidades})`;
        document.querySelectorAll('[data-cart-count]').forEach((marca) => {
            marca.textContent = unidades > 9 ? '9+' : String(unidades);
            marca.classList.toggle('hidden', unidades === 0);
            marca.classList.toggle('grid', unidades > 0);
        });

        dialogo.querySelector('[data-cart-total]').textContent = formato(total);
        dialogo.querySelector('[data-cart-saved]').textContent = formato(ahorro);
        botonPagar.disabled = items.length === 0;
        botonLimpiar.disabled = items.length === 0;
        vacio.classList.toggle('hidden', items.length > 0);
        vacio.classList.toggle('flex', items.length === 0);

        // Al repintar se destruyen los botones: se recuerda cuál tenía el foco para devolvérselo
        const enfocado = lista.contains(document.activeElement) ? document.activeElement : null;
        const memoria = enfocado && { id: enfocado.closest('li[data-id]')?.dataset.id, accion: enfocado.dataset.action };

        lista.replaceChildren(...items.map((item) => {
            const fila = plantilla.content.firstElementChild.cloneNode(true);
            fila.dataset.id = item.id;
            fila.querySelector('[data-f="marca"]').textContent = item.marca;
            fila.querySelector('[data-f="nombre"]').textContent = item.nombre;
            fila.querySelector('[data-f="precio"]').textContent = formato(item.precio);
            fila.querySelector('[data-f="anterior"]').textContent = formato(item.anterior);
            fila.querySelector('[data-f="cantidad"]').textContent = item.cantidad;
            fila.querySelector('[data-action="menos"]').disabled = item.cantidad <= 1;

            // Foto del producto; sin foto se queda el cubo de marcador
            const foto = fila.querySelector('[data-f="imagen"]');
            if (item.imagen) {
                foto.src = item.imagen;
                foto.alt = item.nombre;
                foto.classList.remove('hidden');
                fila.querySelector('[data-f="marcador"]').classList.add('hidden');
            }
            return fila;
        }));

        if (memoria) {
            const fila = [...lista.children].find((li) => li.dataset.id === memoria.id);
            const destino = fila?.querySelector(`[data-action="${memoria.accion}"]:not(:disabled)`)
                ?? fila?.querySelector('[data-action]:not(:disabled)')
                ?? dialogo.querySelector('[data-cart-close]');
            destino?.focus();
        }
    };

    const cambiar = (nuevos) => { items = nuevos; guardar(items); pintar(); };

    const abrir = () => {
        if (!dialogo.open) dialogo.showModal();
        document.documentElement.classList.add('overflow-hidden');
    };
    const cerrar = () => dialogo.close();

    const agregar = (producto) => {
        const existente = items.find((i) => i.id === producto.id);
        if (existente) {
            existente.cantidad += 1;
            cambiar([...items]);
            anunciar(`${producto.nombre} agregado. Cantidad: ${existente.cantidad}.`);
        } else {
            cambiar([...items, { ...producto, cantidad: 1 }]);
            anunciar(`${producto.nombre} agregado al carrito.`);
        }
        abrir();
    };

    // Abrir y cerrar
    document.querySelectorAll('[data-cart-open]').forEach((boton) => boton.addEventListener('click', abrir));
    dialogo.querySelectorAll('[data-cart-close]').forEach((boton) => boton.addEventListener('click', cerrar));
    // El panel ocupa solo la derecha: un clic sobre el resto (el fondo oscurecido) llega al propio <dialog>
    dialogo.addEventListener('click', (evento) => {
        if (evento.target === dialogo) cerrar();
    });
    dialogo.addEventListener('close', () => document.documentElement.classList.remove('overflow-hidden'));

    // "Agregar al carrito" desde cualquier tarjeta de producto
    document.addEventListener('click', (evento) => {
        const boton = evento.target.closest('[data-add-cart]');
        if (!boton) return;
        try { agregar(JSON.parse(boton.dataset.producto)); } catch { /* datos inválidos: se ignora */ }
    });

    // Acciones por producto
    lista.addEventListener('click', (evento) => {
        const accion = evento.target.closest('[data-action]');
        const fila = evento.target.closest('li[data-id]');
        if (!accion || !fila) return;

        const id = fila.dataset.id;
        if (accion.dataset.action === 'eliminar') {
            cambiar(items.filter((i) => i.id !== id));
            anunciar('Producto eliminado del carrito.');
            return;
        }

        cambiar(items.map((i) => {
            if (i.id !== id) return i;
            const cantidad = accion.dataset.action === 'mas' ? i.cantidad + 1 : Math.max(1, i.cantidad - 1);
            return { ...i, cantidad };
        }));
    });

    botonLimpiar.addEventListener('click', () => { cambiar([]); anunciar('Carrito vacío.'); });

    // Sincronizar con otras pestañas
    window.addEventListener('storage', (evento) => {
        if (evento.key === CLAVE) { items = leer(); pintar(); }
    });

    pintar();
}
