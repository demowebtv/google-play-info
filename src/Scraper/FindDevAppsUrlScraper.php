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

use Demowebtv\GPlay\GPlayApps;
use Demowebtv\GPlay\HttpClient\ParseHandlerInterface;
use Demowebtv\GPlay\Util\ScraperUtil;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
class FindDevAppsUrlScraper implements ParseHandlerInterface
{
    /**
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array             $options
     *
     * @throws \Demowebtv\GPlay\Exception\GooglePlayException
     *
     * @return string|null
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response, array &$options = []): ?string
    {
        $scriptData = ScraperUtil::extractScriptData($response->getBody()->getContents());
        $scriptDataAppsUrl = ScraperUtil::getValue($scriptData, 'ds:3.0.1.0.21.1.2.4.2');

        if (\is_string($scriptDataAppsUrl)) {
            return GPlayApps::GOOGLE_PLAY_URL . $scriptDataAppsUrl;
        }

        return null;
    }
}
