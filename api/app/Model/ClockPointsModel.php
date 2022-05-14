<?php

namespace App\Model;

/**
 * \App\Model\ClockPointsModel
 */
class ClockPointsModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'a_clock_points';

    public const CREATED_AT = "createdAt";

    public const UPDATED_AT = "updatedAt";
}