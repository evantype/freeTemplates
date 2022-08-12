<?php

namespace App\Console\Commands;

use App\Services\ParsingService;
use Illuminate\Console\Command;

use Throwable;

class ParseSiteTemplates extends Command
{
    protected $signature = 'parse:site_templates {page=1} {order=asc} {endpoint=10}';

    protected $description = 'parse site templates';

    public function __construct(public ParsingService $parsingService)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        try {
            $this->parsingService->parseThemelock(
                $this->argument('page'),
                $this->argument('order'),
                $this->argument('endpoint')
            );
        } catch (Throwable $e) {
            $this->error($e->getMessage());
        }

        $this->info('Я всё');

        return 0;
    }
}
