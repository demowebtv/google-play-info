<?php

/** @noinspection PhpUnusedPrivateFieldInspection */
declare(strict_types=1);

/*
 * Copyright (c) Ne-Lexa
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/Ne-Lexa/google-play-scraper
 */

namespace Demowebtv\GPlay\Enum;

use Demowebtv\Enum;

/**
 * Contains all valid values for the age parameter.
 *
 * @method static AgeEnum FIVE_UNDER() Returns the value of the age parameter for age 5 and under.
 * @method static AgeEnum SIX_EIGHT()  Returns the value of the age parameter for age 6 - 8 years.
 * @method static AgeEnum NINE_UP()    Returns the value of the age parameter for ages 9 and up.
 */
class AgeEnum extends Enum
{
    /** @var string Ages 5 and under */
    private const FIVE_UNDER = 'AGE_RANGE1';

    /** @var string Ages 6-8 */
    private const SIX_EIGHT = 'AGE_RANGE2';

    /** @var string Ages 9 & Up */
    private const NINE_UP = 'AGE_RANGE3';
}
