<?php

namespace Tests\Feature;

use Tests\TestCase;

class TiendaTest extends TestCase
{
    public function test_el_inicio_muestra_las_secciones_del_diseno(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSeeText('Todas las categorías')
            ->assertSeeText('Bombas de la semana')
            ->assertSeeText('Lo más vendido')
            ->assertSeeText('Tus últimos vistos')
            ->assertSeeText('Pagos seguros con tarjeta, transferencia y billeteras digitales');
    }

    public function test_el_inicio_renderiza_las_tarjetas_de_producto(): void
    {
        // 8 en "Bombas de la semana" + 20 en "Lo más vendido" + 20 en "Tus últimos vistos"
        $this->assertSame(48, substr_count($this->get('/')->getContent(), '<article'));
    }

    public function test_los_iconos_heroicons_se_incrustan_como_svg(): void
    {
        $html = $this->get('/')->getContent();

        $this->assertStringContainsString('<svg', $html);
        $this->assertStringNotContainsString('data-slot="icon"', $html);
    }

    public function test_el_inicio_incluye_el_carrito_y_los_botones_para_agregar(): void
    {
        $html = $this->get('/')->getContent();

        $this->assertStringContainsString('id="carrito"', $html);
        $this->assertStringContainsString('Tu carrito está vacío', $html);
        $this->assertStringContainsString('data-cart-open', $html);
        $this->assertSame(48, substr_count($html, 'data-add-cart'));
    }
}
