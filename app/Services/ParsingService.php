<?php

namespace App\Services;

use App\Models\SiteTemplate;
use DiDom\Document;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;
use Psy\Util\Json;
use React\EventLoop\Loop;
use React\Http\Browser;
use Clue\React\Block;

use Throwable;

use function array_filter;
use function array_map;
use function explode;
use function implode;
use function rand;
use function sprintf;

use const PHP_EOL;

class ParsingService
{
    public function __construct(public Browser $client)
    {
    }

    /**
     * @throws \Exception
     */
    public function parseThemelock(int $page, string $order): void
    {
        switch ($order) {
            case 'asc':
                while ($page < 100) {
                    $this->parsePage($page);
                    $page++;
                }
                break;
            case 'desc':
                while ($page > 1590) {
                    $this->parsePage($page);
                    $page--;
                }
                break;
            default:
                $this->parsePage($page);
        }
    }

    /**
     * @param string          $srcLink
     * @param \DiDom\Document $templateBody
     * @return void
     * @throws \Exception
     */
    function handleTemplate(string $srcLink, Document $templateBody): void
    {
        try {
            Block\await(
                $this->client->get($srcLink)->then(
                    function (ResponseInterface $response) use ($srcLink, $templateBody) {
                        $title = $templateBody->first('.entry-title')->text();
                        echo sprintf("Идет парсинг шаблона {$title}%s", PHP_EOL);

                        $download_links = array_filter(
                            explode(
                                '<br>',
                                Str::replace(['<!--QuoteEBegin-->', '<!--QuoteEnd-->'],
                                    '',
                                    $templateBody->first('.single-body .quote')->innerHtml())
                            ),
                            fn($item) => !empty($item)
                        );
                        $sourceBody     = new Document($response->getBody()->__toString());
                        $cover          = sprintf("%s.png", \hash('md5', implode([$title, $srcLink])));

                        echo sprintf("Загружаю превью%s", PHP_EOL);
                        Storage::put(
                            sprintf("public/themeforest/%s", $cover),
                            $sourceBody->first('.item-preview img')->getAttribute('src')
                        );
                        $demo   = "https://themeforest.net" . $sourceBody->first(
                                'a.btn-icon.live-preview'
                            )->getAttribute('href');
                        $arData = [
                            'title'          => $title,
                            'cover'          => $cover,
                            'demo'           => $demo,
                            'original_link'  => $srcLink,
                            'download_links' => Json::encode($download_links),
                        ];

                        if (SiteTemplate::where([
                            'title'         => $title,
                            'original_link' => $srcLink,
                        ])->count()) {
                            throw new Exception('Уперлись в повторные записи');
                        } else {
                            echo sprintf("Добавляю новую запись в таблицу%s", PHP_EOL);
                            $siteTemplate = new SiteTemplate($arData);
                            $siteTemplate->save();
                        }
                    }
                )
            );
        } catch (Throwable $exception) {
            echo sprintf("%s%s", $exception->getMessage(), PHP_EOL);
        }
        Block\sleep(rand(5, 15));
    }

    /**
     * @return array|\React\Promise\PromiseInterface[]
     */
    function getTemplatesFromPage($body): array
    {
        echo sprintf("Собираю посты со страницы..%s", PHP_EOL);

        $posts = $body->find('.post');

        return array_map(function ($post) {
            return $this->client->get($post->first('.post__title a')->attr('href'));
        }, $posts);
    }

    /**
     * @param int $page
     * @return void
     * @throws \Exception
     */
    public function parsePage(int $page): void
    {
        echo sprintf("Начинаю парсить %d страницу%s", $page, PHP_EOL);
        Block\await(
            $this->client->get("https://www.themelock.com/pag/{$page}/")->then(
                function (ResponseInterface $response) use ($page) {
                    $body     = new Document($response->getBody()->__toString());
                    $promises = $this->getTemplatesFromPage($body);

                    try {
                        $responses = Block\awaitAll($promises, Loop::get());
                        foreach ($responses as $detailResponse) {
                            $templateBody = new Document($detailResponse->getBody()->__toString());
                            $srcLink      = $templateBody->first('.single-body a')->text();
                            if (!Str::of($srcLink)->contains("themeforest")) {
                                echo sprintf("%s%s", $srcLink, PHP_EOL);
                                echo sprintf("Шаблон находится не на themeforest... пропускаю%s", PHP_EOL);
                                continue;
                            }
                            $this->handleTemplate($srcLink, $templateBody);
                        }
                    } catch (Exception $e) {
                        echo sprintf("{$e->getMessage()}%s", PHP_EOL);
                        echo sprintf("Остановился на {$page} странице%s", PHP_EOL);
                    }
                }
            )
        );
        Block\sleep(rand(30, 60));
    }

}
