<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Produto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;

class ProdutoControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Teste para listar produtos.
     *
     * @return void
     */
    public function test_index()
    {
        Produto::factory()->create();

        $response = $this->get('/api/produtos');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'code',
                        'product_name',
                        'brands',
                        'categories',
                        'status',
                    ]
                ]
            ]);
    }

    /**
     * Teste para mostrar um produto.
     *
     * @return void
     */
    public function test_show()
    {
        $product = Produto::factory()->create([
            'code' => '1234567890',
        ]);

        $response = $this->getJson('/api/produtos/' . $product->code);

        $response->assertStatus(200)
            ->assertJson([
                'product_name' => $product->product_name,
                'code' => $product->code,
                'status' => $product->status
            ]);
    }

    /**
     * Teste para atualizar um produto.
     *
     * @return void
     */
    public function test_update()
    {
        $product = Produto::factory()->create([
            'code' => '1234567890',
        ]);

        $updateData = [
            'product_name' => 'Novo Produto',
            'brands' => 'Marca Atualizada',
            'categories' => 'Categoria Atualizada',
        ];

        $response = $this->put('/api/produtos/' . $product->code, $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'product_name' => 'Novo Produto',
                'brands' => 'Marca Atualizada',
                'categories' => 'Categoria Atualizada'
            ]);

        // Verifica se o produto foi atualizado no banco de dados
        $this->assertDatabaseHas('produtos', $updateData);
    }

    /**
     * Teste para mover um produto para o status 'trash'.
     *
     * @return void
     */
    public function test_destroy()
    {
        $product = Produto::factory()->create([
            'code' => '1234567890',
        ]);

        $response = $this->delete('/api/produtos/' . $product->code);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Produto movido para Trash',
            ]);

        $this->assertDatabaseHas('produtos', [
            'code' => $product->code,
            'status' => 'trash',
        ]);
    }

    /**
     * Teste para verificar o status da API.
     *
     * @return void
     */
    public function test_status()
    {
        Cache::put('last_cron_execution_time', time());

        $response = $this->get('/api');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'database_connection',
                'last_cron_execution',
                'memory_usage'
            ]);
    }
}
