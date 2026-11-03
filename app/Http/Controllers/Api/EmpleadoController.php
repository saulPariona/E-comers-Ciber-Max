<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmpleadoRequest;
use App\Models\Empleado;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class EmpleadoController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Empleado::with(['usuario', 'supervisor'])->paginate(15));
    }

    public function store(EmpleadoRequest $request): JsonResponse
    {
        $empleado = Empleado::create($request->validated());

        return response()->json($empleado->load(['usuario', 'supervisor']), 201);
    }

    public function show(Empleado $empleado): JsonResponse
    {
        return response()->json($empleado->load(['usuario', 'supervisor']));
    }

    public function update(EmpleadoRequest $request, Empleado $empleado): JsonResponse
    {
        $empleado->update($request->validated());

        return response()->json($empleado->load(['usuario', 'supervisor']));
    }

    public function destroy(Empleado $empleado): JsonResponse
    {
        try {
            $empleado->delete();
        } catch (QueryException $e) {
            if (! in_array($e->getCode(), ['23503', '23000'], true)) {
                throw $e;
            }

            return response()->json(['message' => 'No se puede eliminar: tiene registros relacionados.'], 409);
        }

        return response()->json(null, 204);
    }
}
