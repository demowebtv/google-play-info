<?php

declare(strict_types=1);

/**
 * @author   Ne-Lexa
 * @license  MIT
 *
 * @see      https://github.com/Ne-Lexa/google-play-info
 */

namespace Demowebtv\GPlay\Scraper;

use Demowebtv\HttpClient\ResponseHandlerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
class ExistsAppScraper implements ResponseHandlerInterface
{
    /**
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     *
     * @return mixed
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response)
    {
        return $response->getStatusCode() < 300;
    }
}
