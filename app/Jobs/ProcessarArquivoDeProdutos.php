<?php

namespace App\Jobs;

use App\Enum\ProdutoEnum;
use App\Models\Produto;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProcessarArquivoDeProdutos implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    protected $file;
    protected $lines;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function handle()
    {
        $url = "https://challenges.coode.sh/food/data/json/$this->file";
        $response = Http::get($url);

        if ($response->successful()) {
            Storage::put($this->file, $response->body());

            if (Storage::exists($this->file)) {
                $this->extrairArquivo($this->file);
            }
        }

        if (!$this->lines) return false;

        $this->finalizar();
    }

    private function extrairArquivo($tempPath)
    {
        $stream = gzopen(Storage::path($tempPath), 'r');
        $this->lines = [];
        $lineCount = 0;

        while (!gzeof($stream) && $lineCount < 100) {
            $line = gzgets($stream);

            if ($line !== false) {
                $this->lines[] = json_decode($line, true);
                $lineCount++;
            }
        }

        gzclose($stream);
    }

    private function finalizar()
    {
        foreach ($this->lines as $produto) {
            Produto::updateOrCreate(
                ['code' => $produto['code']],
                [
                    'product_name' => $produto['product_name'] ?? null,
                    'url' => $produto['url'] ?? null,
                    'brands' => $produto['brands'] ?? null,
                    'categories' => $produto['categories'] ?? null,
                    'image_url' => $produto['image_url'] ?? null,
                    'origins' => $produto['origins'] ?? null,
                    'last_modified_t' => $produto['last_modified_t'] ?? null,
                    'last_modified_datetime' => $produto['last_modified_datetime'] ?? null,
                    'imported_t' => now()->timestamp,
                    'imported_datetime' => now(),
                    'status' => Arr::random(ProdutoEnum::getStatus())
                ]
            );
        }
    }
}
