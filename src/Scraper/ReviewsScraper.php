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

use Demowebtv\GPlay\HttpClient\ParseHandlerInterface;
use Demowebtv\GPlay\Model\AppId;
use Demowebtv\GPlay\Scraper\Extractor\ReviewsExtractor;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
class ReviewsScraper implements ParseHandlerInterface
{
    /** @var AppId */
    private $requestApp;

    /**
     * ReviewsScraper constructor.
     *
     * @param AppId $requestApp
     */
    public function __construct(AppId $requestApp)
    {
        $this->requestApp = $requestApp;
    }

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

        if (!isset($json[0][2])) {
            return [[], null];
        }
        $json = \GuzzleHttp\json_decode($json[0][2], true);

        if (empty($json[0])) {
            return [[], null];
        }
        $reviews = ReviewsExtractor::extractReviews($this->requestApp, $json[0]);
        $nextToken = $json[1][1] ?? null;

        return [$reviews, $nextToken];
    }
}
