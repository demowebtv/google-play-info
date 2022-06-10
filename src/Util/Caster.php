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

namespace Demowebtv\GPlay\Util;

use Demowebtv\GPlay\Enum\CategoryEnum;
use Demowebtv\GPlay\Model\App;
use Demowebtv\GPlay\Model\AppId;
use Demowebtv\GPlay\Model\AppInfo;
use Demowebtv\GPlay\Model\Category;
use Demowebtv\GPlay\Model\Developer;

/**
 * @internal
 */
final class Caster
{
    /**
     * @param string|int|Developer|App|AppInfo $developerId
     *
     * @return string
     */
    public static function castToDeveloperId($developerId): string
    {
        if ($developerId instanceof AppInfo) {
            return $developerId->getDeveloper()->getId();
        }

        if ($developerId instanceof Developer) {
            return $developerId->getId();
        }

        if (\is_int($developerId)) {
            return (string) $developerId;
        }

        return $developerId;
    }

    /**
     * @param Category|CategoryEnum|string $category
     *
     * @return string
     */
    public static function castToCategoryId($category): string
    {
        if ($category instanceof CategoryEnum) {
            return $category->value();
        }

        if ($category instanceof Category) {
            return $category->getId();
        }

        return (string) $category;
    }

    /**
     * Casts the application id to the {@see AppId} type.
     *
     * @param string|AppId $appId   application ID
     * @param string       $locale
     * @param string       $country
     *
     * @return AppId application ID such as {@see AppId}
     */
    public static function castToAppId($appId, string $locale, string $country): AppId
    {
        if ($appId === null) {
            throw new \InvalidArgumentException('Application ID is null');
        }

        if (\is_string($appId)) {
            return new AppId($appId, $locale, $country);
        }

        return $appId;
    }
}
