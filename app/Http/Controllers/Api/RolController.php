<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RolRequest;
use App\Models\Rol;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class RolController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Rol::query()->paginate(15));
    }

    public function store(RolRequest $request): JsonResponse
    {
        $rol = Rol::create($request->validated());

        return response()->json($rol, 201);
    }

    public function show(Rol $rol): JsonResponse
    {
        return response()->json($rol);
    }

    public function update(RolRequest $request, Rol $rol): JsonResponse
    {
        $rol->update($request->validated());

        return response()->json($rol);
    }

    public function destroy(Rol $rol): JsonResponse
    {
        try {
            $rol->delete();
        } catch (QueryException $e) {
            if (! in_array($e->getCode(), ['23503', '23000'], true)) {
                throw $e;
            }

            return response()->json(['message' => 'No se puede eliminar: tiene registros relacionados.'], 409);
        }

        return response()->json(null, 204);
    }
}
