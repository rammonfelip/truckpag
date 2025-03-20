<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProdutoResource;
use App\Models\Produto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class ProdutoController extends Controller
{
    /**
     * Exibe todos os produtos com paginação.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 20);
        $products = Produto::paginate($perPage);

        return ProdutoResource::collection($products);
    }

    /**
     * Exibe um produto específico.
     *
     * @param string $code
     * @return JsonResponse
     */
    public function show(string $code)
    {
        $product = Produto::where('code', $code)->firstOrFail();
        return response()->json(new ProdutoResource($product));
    }

    /**
     * Atualiza os dados de um produto.
     *
     * @param Request $request
     * @param string $code
     * @return JsonResponse
     */
    public function update(Request $request, string $code): JsonResponse
    {
        try {
            $product = Produto::where('code', $code)->firstOrFail();

            $validatedData = $request->validate([
                'product_name' => 'required|string|max:255',
                'brands' => 'nullable|string',
                'categories' => 'nullable|string',
            ]);

            $product->update($validatedData);

            return response()->json(new ProdutoResource($product), 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Internal server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Move o produto para o status "trash".
     *
     * @param string $code
     * @return JsonResponse
     */
    public function destroy(string $code): JsonResponse
    {
        $product = Produto::where('code', $code)->firstOrFail();

        $product->update(['status' => 'trash']);

        return response()->json([
            'message' => 'Produto movido para Trash',
            'product' => new ProdutoResource($product)
        ], 200);
    }

    /**
     * Retorna o status da API.
     *
     * @return JsonResponse
     */
    public function status()
    {
        $lastCronExecution = Cache::get('last_cron_execution_time');

        $status = [
            'status' => 'OK',
            'database_connection' => 'active',
            'last_cron_execution' => $lastCronExecution ? date('Y-m-d H:i:s', $lastCronExecution) : null,
            'memory_usage' => $this->getMemoryUsage(),
        ];

        return response()->json($status);
    }

    /**
     * Retorna o uso de memória do servidor.
     *
     * @return string
     */
    private function getMemoryUsage(): string
    {
        $memoryUsage = memory_get_usage(true);
        return number_format($memoryUsage / 1024 / 1024, 2) . ' MB';
    }
}
