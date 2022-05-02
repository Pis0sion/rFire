<?php

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * \App\Constants\ActivityStatusConstants
 */
#[Constants]
class ActivityStatusConstants extends AbstractConstants
{

    /**
     * @Message("startEnrollAt")
     */
    const START_ENROLL_AT = 1;

    /**
     * @Message("endEnrollAt")
     */
    const END_ENROLL_AT = 2;

    /**
     * @Message("startAt")
     */
    const START_AT = 3;

    /**
     * @Message("endAt")
     */
    const END_AT = 4;
}