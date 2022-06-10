<?php

declare(strict_types=1);

/*
 * Copyright (c) Ne-Lexa
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/Ne-Lexa/google-play-scraper
 */

namespace Demowebtv\GPlay\Scraper;

use GuzzleHttp\Psr7\Query;
use Demowebtv\GPlay\GPlayApps;
use Demowebtv\GPlay\HttpClient\ParseHandlerInterface;
use Demowebtv\GPlay\Scraper\Extractor\AppsExtractor;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
class PlayStoreUiAppsScraper implements ParseHandlerInterface
{
    /**
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array             $options
     *
     * @return array
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response, array &$options = []): array
    {
        $contents = substr($response->getBody()->getContents(), 5);
        $json = \GuzzleHttp\json_decode($contents, true);

        if (empty($json[0][2])) {
            return [[], null];
        }
        $json = \GuzzleHttp\json_decode($json[0][2], true);

        $json = $json[0][22] ?? $json[0][21];
        if (empty($json)) {
            return [[], null];
        }

        $query = Query::parse($request->getUri()->getQuery());
        $locale = $query[GPlayApps::REQ_PARAM_LOCALE] ?? GPlayApps::DEFAULT_LOCALE;
        $country = $query[GPlayApps::REQ_PARAM_COUNTRY] ?? GPlayApps::DEFAULT_COUNTRY;

        $apps = [];

        foreach ($json[0] as $data) {
            $apps[] = AppsExtractor::extractApp(isset($data[1]) ? $data : $data[0], $locale, $country);
        }

        $nextToken = $json[1][3][1] ?? null;

        return [$apps, $nextToken];
    }
}
