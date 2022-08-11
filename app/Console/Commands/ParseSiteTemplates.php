<?php

namespace App\Console\Commands;

use App\Models\SiteTemplate;
use DiDom\Document;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;
use React\EventLoop\Loop;
use React\Http\Browser;
use Clue\React\Block;

use function array_filter;
use function explode;

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
            $body     = new Document($response->getBody()->__toString());
            $posts    = $body->find('.post');
            $promises = [];
            foreach ($posts as $post) {
                $promises[] = $client->get($post->first('.post__title a')->attr('href'));
            }

            try {
                $responses = Block\awaitAll($promises, Loop::get());

                $result = new Collection();
                $i      = 0;

                foreach ($responses as $detailResponse) {
                    $templateBody = new Document($detailResponse->getBody()->__toString());

                    $title          = $templateBody->first('.entry-title')->text();
                    $download_links = array_filter(
                        explode(
                            '<br>',
                            Str::replace(['<!--QuoteEBegin-->', '<!--QuoteEnd-->'],
                                '',
                                $templateBody->first('.single-body .quote')->innerHtml())
                        ),
                        fn($item) => !empty($item)
                    );
                    $srcLink        = $templateBody->first('.single-body a')->text();

                    Block\await(
                        $client->get($srcLink)->then(
                            function (ResponseInterface $response) use ($download_links, $title, $result) {
                                $sourceBody = new Document($response->getBody()->__toString());
                                $cover      = $sourceBody->first('.item-preview img')->getAttribute('src');
                                $demo       = "https://themeforest.net" . $sourceBody->first(
                                        'a.btn-icon.live-preview'
                                    )->getAttribute('href');

                                $siteTemplate = new SiteTemplate([
                                    'title'          => $title,
                                    'download_links' => $download_links,
                                    'cover'          => $cover,
                                    'demo'           => $demo
                                ]);
//
//                                $siteTemplate = new SiteTemplate(
//                                    compact([
//                                        'title',
//                                        'download_links',
//                                        'cover',
//                                        'demo'
//                                    ])
//                                );


                                $siteTemplate->save();
                            }
                        )
                    );

                    $i++;
                    if ($i > 2) {
                        break;
                    }
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        });


        return 0;
    }
}
