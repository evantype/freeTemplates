<?php

namespace App\Services;

use App\Models\SiteTemplate;
use DiDom\Document;
use Exception;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;
use Psy\Util\Json;
use React\EventLoop\Loop;
use React\Http\Browser;
use Clue\React\Block;

use function array_filter;
use function array_map;
use function explode;
use function info;

class ParsingService
{
    public function __construct(public Browser $client)
    {
    }

    public function parseThemelock(int $page, string $order): void
    {
        echo "Начинаю парсить. {PHP_EOL}";

        $this->client->get("https://www.themelock.com/pag/{$page}/")->then(
            function (ResponseInterface $response) {
                $body     = new Document($response->getBody()->__toString());
                $promises = $this->getTemplatesFromPage($body);

                try {
                    $responses = Block\awaitAll($promises, Loop::get());
                    foreach ($responses as $detailResponse) {
                        $templateBody = new Document($detailResponse->getBody()->__toString());
                        $srcLink      = $templateBody->first('.single-body a')->text();
                        $this->handleTemplate($srcLink, $templateBody);
                        break;
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }
        );

    }

    /**
     * @param string          $srcLink
     * @param \DiDom\Document $templateBody
     * @return void
     * @throws \Exception
     */
    function handleTemplate(string $srcLink, Document $templateBody): void
    {
        Block\await(
            $this->client->get($srcLink)->then(
                function (ResponseInterface $response) use ($srcLink, $templateBody) {
                    $title          = $templateBody->first('.entry-title')->text();
                    $download_links = Json::encode(
                        array_filter(
                            explode(
                                '<br>',
                                Str::replace(['<!--QuoteEBegin-->', '<!--QuoteEnd-->'],
                                    '',
                                    $templateBody->first('.single-body .quote')->innerHtml())
                            ),
                            fn($item) => !empty($item)
                        )
                    );

                    $sourceBody = new Document($response->getBody()->__toString());
                    $cover      = $sourceBody->first('.item-preview img')->getAttribute('src');
                    $demo       = "https://themeforest.net" . $sourceBody->first(
                            'a.btn-icon.live-preview'
                        )->getAttribute('href');

                    $siteTemplate = new SiteTemplate([
                        'title'          => $title,
                        'download_links' => $download_links,
                        'cover'          => $cover,
                        'demo'           => $demo,
                        'original_link'  => $srcLink
                    ]);

                    $siteTemplate->save();
                }
            )
        );
    }

    /**
     * @return array|\React\Promise\PromiseInterface[]
     */
    function getTemplatesFromPage($body): array
    {
        info('Собираю посты со страницы..');

        $posts = $body->find('.post');

        return array_map(function ($post) {
            return $this->client->get($post->first('.post__title a')->attr('href'));
        }, $posts);
    }

}
