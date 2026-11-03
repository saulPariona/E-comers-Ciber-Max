<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmpresaRequest;
use App\Models\Empresa;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class EmpresaController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Empresa::with(['usuario', 'responsable'])->paginate(15));
    }

    public function store(EmpresaRequest $request): JsonResponse
    {
        $empresa = Empresa::create($request->validated());

        return response()->json($empresa->load(['usuario', 'responsable']), 201);
    }

    public function show(Empresa $empresa): JsonResponse
    {
        return response()->json($empresa->load(['usuario', 'responsable']));
    }

    public function update(EmpresaRequest $request, Empresa $empresa): JsonResponse
    {
        $empresa->update($request->validated());

        return response()->json($empresa->load(['usuario', 'responsable']));
    }

    public function destroy(Empresa $empresa): JsonResponse
    {
        try {
            $empresa->delete();
        } catch (QueryException $e) {
            if (! in_array($e->getCode(), ['23503', '23000'], true)) {
                throw $e;
            }

            return response()->json(['message' => 'No se puede eliminar: tiene registros relacionados.'], 409);
        }

        return response()->json(null, 204);
    }
}
