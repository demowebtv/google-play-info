<?php

declare(strict_types=1);

/**
 * @author   Ne-Lexa
 * @license  MIT
 *
 * @see      https://github.com/Ne-Lexa/google-play-info
 */

namespace Demowebtv\GPlay\Scraper;

use Demowebtv\GPlay\Exception\GooglePlayException;
use Demowebtv\GPlay\GPlayApps;
use Demowebtv\GPlay\Util\ScraperUtil;
use Demowebtv\HttpClient\ResponseHandlerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
class FindDevAppsUrlScraper implements ResponseHandlerInterface
{
    /**
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     *
     * @throws GooglePlayException
     *
     * @return string|null
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response): ?string
    {
        $scriptData = ScraperUtil::extractScriptData($response->getBody()->getContents());

        $scriptDataApps = null;

        foreach ($scriptData as $key => $scriptValue) {
            if (isset($scriptValue[0][1][0][0][3][4][2])) { // ds:3
                $scriptDataApps = $scriptValue;
                break;
            }
        }

        if ($scriptDataApps === null) {
            throw (new GooglePlayException('Error fetch cluster page'))
                ->setUrl($request->getUri()->__toString())
            ;
        }

        if (isset($scriptDataApps[0][1][0][0][3][4][2])) {
            return GPlayApps::GOOGLE_PLAY_URL . $scriptDataApps[0][1][0][0][3][4][2];
        }

        return null;
    }
}
