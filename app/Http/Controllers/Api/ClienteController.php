<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class ClienteController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Cliente::with(['usuario'])->paginate(15));
    }

    public function store(ClienteRequest $request): JsonResponse
    {
        $cliente = Cliente::create($request->validated());

        return response()->json($cliente->load(['usuario']), 201);
    }

    public function show(Cliente $cliente): JsonResponse
    {
        return response()->json($cliente->load(['usuario']));
    }

    public function update(ClienteRequest $request, Cliente $cliente): JsonResponse
    {
        $cliente->update($request->validated());

        return response()->json($cliente->load(['usuario']));
    }

    public function destroy(Cliente $cliente): JsonResponse
    {
        try {
            $cliente->delete();
        } catch (QueryException $e) {
            if (! in_array($e->getCode(), ['23503', '23000'], true)) {
                throw $e;
            }

            return response()->json(['message' => 'No se puede eliminar: tiene registros relacionados.'], 409);
        }

        return response()->json(null, 204);
    }
}
