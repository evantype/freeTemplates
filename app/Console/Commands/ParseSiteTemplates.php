<?php

namespace App\Console\Commands;

use DiDom\Document;
use Exception;
use Illuminate\Console\Command;

use Psr\Http\Message\ResponseInterface;

use React\EventLoop\Loop;
use React\Http\Browser;

use Clue\React\Block;

use function dd;

use const PHP_EOL;

class ParseSiteTemplates extends Command
{
    protected $signature = 'parse:site_templates';

    protected $description = 'parse site templates';

    public function handle()
    {
        echo sprintf("Начинаю парсить...%s", PHP_EOL);

        $client = new Browser();

        $client->get('https://www.themelock.com/pag/1/')->then(function (ResponseInterface $response) use ($client) {
            $body  = new Document($response->getBody()->__toString());
            $posts = $body->find('.post');
            $promises = [];
            foreach ($posts as $post) {
                $promises[] = $client->get($post->first('.post__title a')->attr('href'));
            }

            try {
                $responses = Block\awaitAll($promises, Loop::get());

                foreach ($responses as $detailResponse) {
                    $templateBody = new Document($detailResponse->getBody()->__toString());
                    echo "====================================================" . PHP_EOL;
                    echo $templateBody->first('.entry-title')->text() . PHP_EOL;
                    echo "====================================================" . PHP_EOL;
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        });

        return 0;
    }
}
