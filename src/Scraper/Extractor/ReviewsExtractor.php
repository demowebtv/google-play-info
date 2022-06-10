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

namespace Demowebtv\GPlay\Scraper\Extractor;

use Demowebtv\GPlay\Model\AppId;
use Demowebtv\GPlay\Model\GoogleImage;
use Demowebtv\GPlay\Model\ReplyReview;
use Demowebtv\GPlay\Model\Review;
use Demowebtv\GPlay\Util\DateStringFormatter;

/**
 * @internal
 */
class ReviewsExtractor
{
    /**
     * @param AppId $requestApp
     * @param array $data
     *
     * @return array
     */
    public static function extractReviews(AppId $requestApp, array $data): array
    {
        $reviews = [];

        foreach ($data as $reviewData) {
            $reviews[] = self::extractReview($requestApp, $reviewData);
        }

        return $reviews;
    }

    /**
     * @param AppId $requestApp
     * @param       $reviewData
     *
     * @return Review
     */
    public static function extractReview(AppId $requestApp, $reviewData): Review
    {
        $reviewId = $reviewData[0];
//        $reviewUrl = $requestApp->getUrl() . '&reviewId=' . urlencode($reviewId);
        $userName = $reviewData[1][0];
        $avatar = (new GoogleImage($reviewData[1][1][3][2]))->setSize(64);
        $date = DateStringFormatter::unixTimeToDateTime($reviewData[5][0]);
        $score = $reviewData[2] ?? 0;
        $text = (string) ($reviewData[4] ?? '');
        $likeCount = $reviewData[6];
        $appVersion = $reviewData[10] ?? null;

        $reply = self::extractReplyReview($reviewData);

        return new Review(
            $reviewId,
//            $reviewUrl,
            $userName,
            $text,
            $avatar,
            $date,
            $score,
            $likeCount,
            $reply,
            $appVersion
        );
    }

    /**
     * @param array $reviewData
     *
     * @return ReplyReview|null
     */
    private static function extractReplyReview(array $reviewData): ?ReplyReview
    {
        if (isset($reviewData[7][1])) {
            $replyText = $reviewData[7][1];
            $replyDate = DateStringFormatter::unixTimeToDateTime($reviewData[7][2][0]);

            if ($replyText && $reviewData) {
                return new ReplyReview(
                    $replyDate,
                    $replyText
                );
            }
        }

        return null;
    }
}
