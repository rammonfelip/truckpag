<?php

namespace App\Console\Commands;

use App\Jobs\ProcessarArquivoDeProdutos;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ImportarProdutos extends Command
{
    protected $signature = 'importar-produtos';
    protected $description = 'Realiza a importação dos produtos presentes no OpenFood';

    public function handle()
    {
        Cache::put('last_cron_execution_time', time());
        $urlFiles = 'https://challenges.coode.sh/food/data/json/index.txt';
        $response = Http::get($urlFiles);

        if ($response->successful()) {
            $files = array_filter(explode("\n", trim($response->body())));

            foreach ($files as $file) {
                ProcessarArquivoDeProdutos::dispatch($file)->onQueue('default');
            }
        }
    }
}
