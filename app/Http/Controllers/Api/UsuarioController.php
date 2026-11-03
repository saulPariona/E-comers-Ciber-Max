<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsuarioRequest;
use App\Models\Usuario;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class UsuarioController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Usuario::with(['rol'])->paginate(15));
    }

    public function store(UsuarioRequest $request): JsonResponse
    {
        $usuario = Usuario::create($request->validated());

        return response()->json($usuario->load(['rol']), 201);
    }

    public function show(Usuario $usuario): JsonResponse
    {
        return response()->json($usuario->load(['rol']));
    }

    public function update(UsuarioRequest $request, Usuario $usuario): JsonResponse
    {
        $usuario->update($request->validated());

        return response()->json($usuario->load(['rol']));
    }

    public function destroy(Usuario $usuario): JsonResponse
    {
        try {
            $usuario->delete();
        } catch (QueryException $e) {
            if (! in_array($e->getCode(), ['23503', '23000'], true)) {
                throw $e;
            }

            return response()->json(['message' => 'No se puede eliminar: tiene registros relacionados.'], 409);
        }

        return response()->json(null, 204);
    }
}
