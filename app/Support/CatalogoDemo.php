<?php

namespace App\Support;

use Illuminate\Support\Str;

/**
 * Datos de ejemplo tomados del diseño de Penpot, solo para maquetar la tienda.
 * Se reemplazan por consultas a la base de datos cuando exista el catálogo.
 */
class CatalogoDemo
{
    private const LAPTOP = 'Ideal para trabajo, estudio y entretenimiento, con arranque rápido y batería de larga duración.';

    private const MONITOR = 'Imagen nítida y colores fieles, con fluidez para trabajar varias horas o jugar sin cortes.';

    private const TECLADO = 'Escritura cómoda y precisa con buena respuesta en cada pulsación.';

    private const MOUSE = 'Movimientos precisos y agarre cómodo para el día a día o para jugar.';

    private const SSD = 'Arranque del sistema en segundos y carga de programas mucho más rápida.';

    private const VIDEO = 'Más cuadros por segundo en tus juegos y aceleración para edición y diseño.';

    private const IMPRESORA = 'Impresiones económicas y de buena calidad para casa u oficina.';

    private const RAM = 'Más velocidad al abrir programas y trabajar con muchas pestañas a la vez.';

    private const AUDIO = 'Sonido claro y envolvente con micrófono para llamadas y partidas.';

    private const VOZ = 'Voz clara para clases virtuales, streaming y grabaciones.';

    /** Categorías del menú horizontal de la cabecera. */
    public static function navegacion(): array
    {
        return [
            ['nombre' => 'Laptops', 'icono' => 'computer-desktop'],
            ['nombre' => 'PCs y componentes', 'icono' => 'cpu-chip'],
            ['nombre' => 'Monitores', 'icono' => 'tv'],
            ['nombre' => 'Impresoras', 'icono' => 'printer'],
            ['nombre' => 'Accesorios', 'icono' => 'cursor-arrow-rays'],
            ['nombre' => 'Redes y wifi', 'icono' => 'wifi'],
            ['nombre' => 'Gamer', 'icono' => 'puzzle-piece'],
        ];
    }

    /** Tarjetas del carrusel "Categorías" del inicio. */
    public static function categorias(): array
    {
        return [
            ['nombre' => 'Laptops', 'icono' => 'computer-desktop'],
            ['nombre' => 'Componentes', 'icono' => 'cpu-chip'],
            ['nombre' => 'Celulares', 'icono' => 'device-phone-mobile'],
            ['nombre' => 'Impresoras', 'icono' => 'printer'],
            ['nombre' => 'Redes', 'icono' => 'wifi'],
            ['nombre' => 'Monitores', 'icono' => 'tv'],
            ['nombre' => 'Periféricos', 'icono' => 'cursor-arrow-rays'],
            ['nombre' => 'Almacenamiento', 'icono' => 'circle-stack'],
            ['nombre' => 'Audio y video', 'icono' => 'speaker-wave'],
            ['nombre' => 'Gaming', 'icono' => 'puzzle-piece'],
            ['nombre' => 'Energía', 'icono' => 'bolt'],
        ];
    }

    /**
     * Árbol del menú lateral "Todas las categorías".
     * La primera categoría es la del diseño; las demás son contenido de ejemplo.
     */
    public static function menu(): array
    {
        return [
            ['nombre' => 'Computadoras y laptops', 'icono' => 'computer-desktop', 'grupos' => [
                'Laptops' => ['Laptops para oficina', 'Laptops para estudiantes', 'Laptops gamer', 'Laptops para diseño', 'Ultradelgadas', '2 en 1 y convertibles', 'Chromebooks'],
                'PC de escritorio' => ['PC para oficina', 'PC gamer', 'PC para diseño y edición', 'Mini PC', 'Todo en uno'],
                'Workstations' => ['Workstation de escritorio', 'Workstation móvil', 'Servidores'],
                'Tablets' => ['Tablets Android', 'Tablets con teclado', 'Tabletas gráficas'],
                'Reacondicionados' => ['Laptops reacondicionadas', 'PC reacondicionadas', 'Con garantía Ciber-Max'],
            ]],
            ['nombre' => 'Componentes de PC', 'icono' => 'cpu-chip', 'grupos' => [
                'Procesadores' => ['Intel Core', 'AMD Ryzen'],
                'Placas madre' => ['Para Intel', 'Para AMD', 'Micro ATX'],
                'Memoria RAM' => ['DDR4', 'DDR5', 'Para laptop'],
                'Tarjetas de video' => ['NVIDIA GeForce', 'AMD Radeon'],
                'Fuentes y cases' => ['Fuentes de poder', 'Cases gamer', 'Refrigeración'],
            ]],
            ['nombre' => 'Monitores', 'icono' => 'tv', 'grupos' => [
                'Por uso' => ['Oficina', 'Gamer', 'Diseño y edición'],
                'Por tamaño' => ['Hasta 24"', '27"', '32" o más', 'Curvos'],
                'Accesorios' => ['Soportes', 'Cables y adaptadores'],
            ]],
            ['nombre' => 'Periféricos', 'icono' => 'cursor-arrow-rays', 'grupos' => [
                'Teclados' => ['Mecánicos', 'Inalámbricos', 'Compactos'],
                'Mouse' => ['Gamer', 'Ergonómicos', 'Inalámbricos'],
                'Otros' => ['Webcams', 'Micrófonos', 'Mousepads'],
            ]],
            ['nombre' => 'Impresión', 'icono' => 'printer', 'grupos' => [
                'Impresoras' => ['Multifuncionales', 'Láser', 'Tinta continua'],
                'Suministros' => ['Cartuchos de tinta', 'Tóner', 'Papel'],
            ]],
            ['nombre' => 'Redes y conectividad', 'icono' => 'wifi', 'grupos' => [
                'Wi-Fi' => ['Routers', 'Repetidores', 'Tarjetas de red'],
                'Cableado' => ['Switches', 'Cables de red', 'Patch panels'],
            ]],
            ['nombre' => 'Almacenamiento', 'icono' => 'circle-stack', 'grupos' => [
                'Discos' => ['Sólidos SATA', 'NVMe M.2', 'Duros internos', 'Externos'],
                'Memorias' => ['USB', 'Tarjetas SD'],
            ]],
            ['nombre' => 'Audio y video', 'icono' => 'speaker-wave', 'grupos' => [
                'Audio' => ['Audífonos', 'Parlantes', 'Micrófonos'],
                'Video' => ['Webcams', 'Proyectores'],
            ]],
            ['nombre' => 'Gaming', 'icono' => 'puzzle-piece', 'grupos' => [
                'Equipos' => ['Laptops gamer', 'PC gamer', 'Monitores gamer'],
                'Accesorios' => ['Sillas gamer', 'Teclados y mouse', 'Audífonos gamer'],
            ]],
            ['nombre' => 'Energía y protección', 'icono' => 'bolt', 'grupos' => [
                'Respaldo' => ['UPS', 'Estabilizadores'],
                'Protección' => ['Supresores de picos', 'Baterías'],
            ]],
            ['nombre' => 'Software y licencias', 'icono' => 'window', 'grupos' => [
                'Sistemas operativos' => ['Windows', 'Linux'],
                'Productividad' => ['Office', 'Antivirus'],
            ]],
            ['nombre' => 'Servicio técnico', 'icono' => 'wrench-screwdriver', 'grupos' => [
                'Servicios' => ['Mantenimiento', 'Reparación', 'Armado de PC', 'Instalación de software'],
            ]],
        ];
    }

    public static function beneficios(): array
    {
        return [
            ['icono' => 'shield-check', 'texto' => 'Productos originales'],
            ['icono' => 'check-badge', 'texto' => 'Garantía de marca'],
            ['icono' => 'truck', 'texto' => 'Envíos a todo el Perú'],
            ['icono' => 'building-storefront', 'texto' => 'Retiro en tienda'],
            ['icono' => 'credit-card', 'texto' => 'Pago seguro'],
        ];
    }

    public static function bombasDeLaSemana(): array
    {
        return self::productos([
            ['Laptop 15.6" Core i5, 16 GB RAM, 512 GB SSD', self::LAPTOP, 1899, 2299],
            ['Monitor 27" QHD 165 Hz panel IPS', self::MONITOR, 649, 799],
            ['Teclado mecánico RGB switches lineales', self::TECLADO, 89, 129],
            ['Audífonos gamer 7.1 con micrófono', self::AUDIO, 179, 229],
            ['Laptop 14" Ryzen 5, 8 GB RAM, 512 GB SSD', self::LAPTOP, 1599, 1899],
            ['Monitor curvo 27" Full HD 144 Hz', self::MONITOR, 799, 999],
            ['Impresora láser monocromática Wi-Fi', self::IMPRESORA, 549, 649],
            ['Disco sólido NVMe M.2 2 TB', self::SSD, 519, 649],
        ]);
    }

    public static function masVendidos(): array
    {
        return self::productos([
            ['Monitor 24" Full HD 75 Hz', self::MONITOR, 499, 599],
            ['Tarjeta de video 8 GB GDDR6', self::VIDEO, 1449, 1699],
            ['Mouse inalámbrico ergonómico', self::MOUSE, 45.9, 69.9],
            ['Disco sólido SATA 1 TB', self::SSD, 159, 199],
            ['Laptop 14" Ryzen 5, 8 GB RAM, 512 GB SSD', self::LAPTOP, 1599, 1899],
            ['PC de escritorio Core i5, 16 GB RAM, 1 TB SSD', 'Equipo armado y probado, listo para oficina, diseño o juegos, con opción de ampliar componentes.', 2399, 2799],
            ['Monitor curvo 27" Full HD 144 Hz', self::MONITOR, 799, 999],
            ['Impresora láser monocromática Wi-Fi', self::IMPRESORA, 549, 649],
            ['Procesador 6 núcleos 4.4 GHz', 'Potencia multitarea para juegos, programación y edición de video.', 699, 849],
            ['Placa madre micro ATX DDR4', 'Base confiable para tu PC con buena conectividad y soporte para actualizaciones.', 389, 459],
            ['Fuente de poder 650 W 80 Plus Bronze', 'Energía estable y eficiente que protege los componentes de tu PC.', 259, 319],
            ['Case gamer ATX con 3 ventiladores ARGB', 'Buen flujo de aire y estilo para mostrar tu armado con iluminación.', 219, 279],
            ['Teclado y mouse inalámbricos', self::TECLADO, 99, 139],
            ['Parlantes 2.1 con subwoofer', 'Sonido potente y equilibrado para música, películas y juegos.', 169, 219],
            ['Estabilizador de voltaje 1200 VA', 'Protege tus equipos de las variaciones de voltaje.', 119, 149],
            ['UPS 1000 VA con regulador', 'Respaldo de energía para guardar tu trabajo ante cortes de luz.', 399, 479],
            ['Disco duro externo 2 TB USB 3.0', 'Espacio de sobra para respaldar tus archivos, fotos y proyectos.', 279, 339],
            ['Memoria USB 128 GB USB 3.2', 'Lleva tus archivos a todas partes con transferencias rápidas.', 39.9, 59.9],
            ['Cooler líquido 240 mm ARGB', 'Mantiene tu procesador fresco y silencioso incluso en largas sesiones.', 329, 399],
            ['Silla gamer reclinable con cojines', 'Comodidad y soporte para largas jornadas de trabajo o juego.', 699, 899],
        ]);
    }

    public static function ultimosVistos(): array
    {
        return self::productos([
            ['Impresora multifuncional tinta continua', self::IMPRESORA, 749, 899],
            ['Router Wi-Fi 6 doble banda', 'Wi-Fi rápido y estable para todos los dispositivos de tu hogar.', 329, 399],
            ['Memoria RAM 16 GB DDR4 3200', self::RAM, 149, 189],
            ['Webcam Full HD con micrófono', self::VOZ, 129, 169],
            ['Laptop 16" Core i7, 32 GB RAM, 1 TB SSD', self::LAPTOP, 4899, 5599],
            ['Monitor 32" 4K UHD panel IPS', self::MONITOR, 1699, 1999],
            ['Tablet 11" 8 GB RAM 256 GB', 'Pantalla amplia y liviana para clases, lectura y entretenimiento en cualquier lugar.', 1199, 1399],
            ['Celular 6.7" 256 GB doble cámara', 'Buen rendimiento y almacenamiento amplio para tus fotos, apps y redes sociales.', 1299, 1599],
            ['Tarjeta de video 16 GB GDDR6X', self::VIDEO, 3299, 3799],
            ['Memoria RAM 32 GB DDR5 6000 MHz', self::RAM, 429, 529],
            ['Disco sólido NVMe M.2 2 TB', self::SSD, 519, 649],
            ['Tarjeta de red Wi-Fi 6 PCIe', 'Conexión inalámbrica estable y veloz para tu PC de escritorio.', 139, 179],
            ['Mouse gamer 26000 DPI con RGB', self::MOUSE, 189, 249],
            ['Teclado mecánico compacto 75%', self::TECLADO, 259, 329],
            ['Audífonos inalámbricos con cancelación de ruido', self::AUDIO, 399, 499],
            ['Micrófono USB para streaming', self::VOZ, 229, 289],
            ['Repetidor Wi-Fi doble banda', 'Amplía la cobertura de tu Wi-Fi a todos los ambientes.', 89, 119],
            ['Switch de red 8 puertos gigabit', 'Conecta más equipos por cable con velocidad gigabit.', 119, 149],
            ['Cartuchos de tinta pack x4', 'Repuestos para mantener tu impresora siempre lista.', 89.9, 109.9],
            ['Soporte para monitor doble brazo', self::MONITOR, 189, 239],
        ]);
    }

    /**
     * @param  array<int, array{0: string, 1: string, 2: float|int, 3: float|int}>  $filas
     */
    private static function productos(array $filas): array
    {
        return array_map(fn (array $f) => [
            'id' => Str::slug($f[0]),
            'marca' => 'MARCA',
            'nombre' => $f[0],
            'descripcion' => $f[1],
            'precio' => $f[2],
            'precio_anterior' => $f[3],
            'descuento' => (int) round((1 - $f[2] / $f[3]) * 100),
        ], $filas);
    }
}
