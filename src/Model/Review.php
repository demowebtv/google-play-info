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

namespace Demowebtv\GPlay\Model;

use Demowebtv\GPlay\GPlayApps;

/**
 * Contains review of application on Google Play store.
 *
 * @see GPlayApps::getReviews() Returns reviews of the Android app
 *     in the Google Play store.
 * @see GPlayApps::getAppsInfo() Returns detailed information about many
 *     android packages.
 */
class Review implements \JsonSerializable
{
    use JsonSerializableTrait;

    /** @var string review id */
    private $id;

    /** @var string review author */
    private $userName;

    /** @var string review text */
    private $text;

    /** @var GoogleImage author's avatar */
    private $avatar;

    /** @var \DateTimeInterface|null review date */
    private $date;

    /** @var int review score */
    private $score;

    /** @var int the number of likes reviews */
    private $countLikes;

    /** @var ReplyReview|null reply review */
    private $reply;

    /** @var string|null */
    private $appVersion;

    /**
     * Creates an Android app review object in the Google Play store.
     *
     * @param string                  $id         review id
     * @param string                  $userName   review author
     * @param string                  $text       review text
     * @param GoogleImage             $avatar     author's avatar
     * @param \DateTimeInterface|null $date       review date
     * @param int                     $score      review score
     * @param int                     $likeCount  the number of likes reviews
     * @param ReplyReview|null        $reply      reply review
     * @param string|null             $appVersion application version
     */
    public function __construct(
        string $id,
//        string $url,
        string $userName,
        string $text,
        GoogleImage $avatar,
        ?\DateTimeInterface $date,
        int $score,
        int $likeCount = 0,
        ?ReplyReview $reply = null,
        ?string $appVersion = null
    ) {
        $this->id = $id;
        $this->userName = $userName;
        $this->text = $text;
        $this->avatar = $avatar;
        $this->date = $date;
        $this->score = $score;
        $this->countLikes = $likeCount;
        $this->reply = $reply;
        $this->appVersion = $appVersion;
    }

    /**
     * Returns review id.
     *
     * @return string review id
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @deprecated URL no longer available
     */
    public function getUrl(): string
    {
        return '';
    }

    /**
     * Returns the username of the review author.
     *
     * @return string author's username
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * Returns the text of the review.
     *
     * @return string review text
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * Returns the user's avatar.
     *
     * @return GoogleImage author's avatar
     */
    public function getAvatar(): GoogleImage
    {
        return $this->avatar;
    }

    /**
     * Returns the date of the review.
     *
     * @return \DateTimeInterface|null date of the review or null if not provided
     */
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    /**
     * Returns a review rating.
     *
     * @return int review score
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * Returns the count of likes of the review.
     *
     * @return int the number of likes reviews
     */
    public function getCountLikes(): int
    {
        return $this->countLikes;
    }

    /**
     * Returns a reply of the review.
     *
     * @return ReplyReview|null response to a review or null if not provided
     */
    public function getReply(): ?ReplyReview
    {
        return $this->reply;
    }

    /**
     * Returns the version of the application for which the comment was made.
     *
     * @return string|null application version
     */
    public function getAppVersion(): ?string
    {
        return $this->appVersion;
    }

    /**
     * Returns class properties as an array.
     *
     * @return array class properties as an array
     */
    public function asArray(): array
    {
        return [
            'id' => $this->id,
            'userName' => $this->userName,
            'text' => $this->text,
            'avatar' => $this->avatar->getUrl(),
            'appVersion' => $this->appVersion,
            'date' => $this->date->format(\DateTime::RFC3339),
            'timestamp' => $this->date->getTimestamp(),
            'score' => $this->score,
            'countLikes' => $this->countLikes,
            'reply' => $this->reply ? $this->reply->asArray() : null,
        ];
    }
}
