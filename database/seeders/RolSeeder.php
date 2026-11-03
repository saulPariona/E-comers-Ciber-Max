<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            Rol::ADMINISTRADOR => ['Administrador', 'Acceso total al sistema'],
            Rol::SUPERVISOR_VENTAS => ['Supervisor de Ventas', 'Supervisa al equipo de ventas'],
            Rol::VENDEDOR => ['Vendedor', 'Atiende y registra ventas'],
            Rol::SUPERVISOR_ALMACEN => ['Supervisor de Almacén', 'Supervisa al equipo de almacén'],
            Rol::ALMACENERO => ['Almacenero', 'Gestiona el stock y los despachos'],
            Rol::CLIENTE => ['Cliente', 'Comprador de la tienda'],
        ];

        foreach ($roles as $id => [$nombre, $descripcion]) {
            Rol::updateOrCreate(
                ['IdRol' => $id],
                ['Nombre' => $nombre, 'Descripcion' => $descripcion, 'Estado' => true],
            );
        }
    }
}
