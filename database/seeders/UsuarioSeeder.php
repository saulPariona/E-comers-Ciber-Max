<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Empresa;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        $this->usuario(Rol::ADMINISTRADOR, 'ADM-0001', 10000001, 'Admin', 'Sistema', 'admin@cibermax.test');
        $supVentas = $this->usuario(Rol::SUPERVISOR_VENTAS, 'SUV-0001', 10000002, 'Carlos', 'Ramírez Soto', 'supervisor.ventas@cibermax.test');
        $vendedor = $this->usuario(Rol::VENDEDOR, 'VEN-0001', 10000003, 'Lucía', 'Torres Vega', 'vendedor@cibermax.test');
        $supAlmacen = $this->usuario(Rol::SUPERVISOR_ALMACEN, 'SUA-0001', 10000004, 'Jorge', 'Mendoza Ruiz', 'supervisor.almacen@cibermax.test');
        $almacenero = $this->usuario(Rol::ALMACENERO, 'ALM-0001', 10000005, 'Pedro', 'Quispe Lima', 'almacenero@cibermax.test');

        $this->empleado($supVentas, null, Empleado::AREA_VENTAS, 'MAÑANA');
        $this->empleado($vendedor, $supVentas, Empleado::AREA_VENTAS, 'TARDE');
        $this->empleado($supAlmacen, null, Empleado::AREA_ALMACEN, 'MAÑANA');
        $this->empleado($almacenero, $supAlmacen, Empleado::AREA_ALMACEN, 'TARDE');

        $cliente = $this->usuario(Rol::CLIENTE, 'CLI-0001', 20000001, 'María', 'Gonzales Paredes', 'cliente@cibermax.test');
        Cliente::updateOrCreate(['IdUsuario' => $cliente->IdUsuario], [
            'DireccionEnvio' => 'Av. Arequipa 1234, Lince',
            'ReferenciaEnvio' => 'Frente al parque',
            'Ubigeo' => '150116',
        ]);

        $empresa = $this->usuario(Rol::CLIENTE, 'CLI-0002', 20000002, 'Tecnología Andina', 'S.A.C.', 'contacto@tecandina.test');
        Cliente::updateOrCreate(['IdUsuario' => $empresa->IdUsuario], [
            'DireccionEnvio' => 'Jr. Lampa 450, Cercado de Lima',
            'ReferenciaEnvio' => 'Oficina 302',
            'Ubigeo' => '150101',
        ]);
        Empresa::updateOrCreate(['IdUsuario' => $empresa->IdUsuario], [
            'IdClienteResponsable' => $cliente->IdUsuario,
            'Ruc' => '20123456789',
            'ReferenciaEnvio' => 'Oficina 302',
            'RazonSocial' => 'TECNOLOGÍA ANDINA S.A.C.',
            'EstadoSunat' => 'ACTIVO',
            'CondicionSunat' => 'HABIDO',
            'Validado' => true,
            'FechaValidacion' => now(),
        ]);
    }

    private function usuario(int $rol, string $codigo, int $documento, string $nombres, string $apellidos, string $email): Usuario
    {
        return Usuario::updateOrCreate(['CodigoUsuario' => $codigo], [
            'IdRol' => $rol,
            'TipoDocumento' => 'DNI',
            'NumeroDocumento' => $documento,
            'Nombres' => $nombres,
            'Apellidos' => $apellidos,
            'Email' => $email,
            'email_verified_at' => now(),
            'Password' => 'password',
            'Estado' => true,
        ]);
    }

    private function empleado(Usuario $usuario, ?Usuario $supervisor, string $area, string $turno): void
    {
        Empleado::updateOrCreate(['IdUsuario' => $usuario->IdUsuario], [
            'IdSupervisor' => $supervisor?->IdUsuario,
            'Area' => $area,
            'Turno' => $turno,
            'FechaIngreso' => '2025-01-15',
        ]);
    }
}
