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
use Demowebtv\GPlay\Exception\GooglePlayException;
use Demowebtv\GPlay\HttpClient\ParseHandlerInterface;
use Demowebtv\GPlay\Model\AppId;
use Demowebtv\GPlay\Model\Review;
use Demowebtv\GPlay\Scraper\Extractor\ReviewsExtractor;
use Demowebtv\GPlay\Util\ScraperUtil;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
class AppSpecificReviewScraper implements ParseHandlerInterface
{
    /** @var AppId */
    private $requestApp;

    /**
     * OneAppReviewScraper constructor.
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
     * @throws \Demowebtv\GPlay\Exception\GooglePlayException
     *
     * @return Review
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response, array &$options = []): Review
    {
        $reviewId = Query::parse($request->getUri()->getQuery())['reviewId'];
        $scriptData = ScraperUtil::extractScriptData($response->getBody()->getContents());

        foreach ($scriptData as $key => $value) {
            if (isset($value[0][0][0]) && $value[0][0][0] === $reviewId) {
                return ReviewsExtractor::extractReview($this->requestApp, $value[0][0]);
            }
        }

        throw new GooglePlayException(
            sprintf('%s application review %s does not exist.', $this->requestApp->getId(), $reviewId)
        );
    }
}
