<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaccion;
use App\Http\Resources\TransaccionResource;
use App\Http\Requests\StoreTransaccionRequest;
use Illuminate\Http\Request;

class TransaccionApiController extends Controller
{
    public function index(Request $request)
    {
        $estado = $request->query('estado');

        $transacciones = Transaccion::when($estado, fn ($q) => $q->where('estado', $estado))
            ->latest()
            ->get();

        return TransaccionResource::collection($transacciones);
    }

    public function show(Transaccion $transaccion)
    {
        return new TransaccionResource($transaccion);
    }

    public function store(StoreTransaccionRequest $request)
    {
        $transaccion = Transaccion::create($request->validated());

        return (new TransaccionResource($transaccion))
            ->response()
            ->setStatusCode(201);
    }

    public function destroy(Transaccion $transaccion)
    {
        $transaccion->delete();

        return response()->noContent();
    }
}
