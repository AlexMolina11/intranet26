<?php

namespace App\Modules\Tik\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Tik\Services\TicketCatalogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CatalogoTicketController extends Controller
{
    public function __construct(
        protected TicketCatalogService $catalogService
    ) {
    }

    public function tiposServicioUsuario(Request $request): JsonResponse
    {
        $items = $this->catalogService->tiposServicioPorUsuario((int) $request->user()->id_usuario);

        return response()->json($items);
    }

    public function serviciosPorTipo(Request $request, string $codigoTipoServicio): JsonResponse
    {
        $items = $this->catalogService->serviciosPorTipoYUsuario(
            $codigoTipoServicio,
            (int) $request->user()->id_usuario
        );

        return response()->json($items);
    }

    public function incidenciasUsuario(Request $request): JsonResponse
    {
        $items = $this->catalogService->incidenciasPorUsuario((int) $request->user()->id_usuario);

        return response()->json($items);
    }
}