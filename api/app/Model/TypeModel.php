<?php

namespace App\Model;

/**
 * \App\Model\TypeModel
 */
class TypeModel extends Model
{
    /**
     * @var string
     */
    protected $table = "a_type";

    public const CREATED_AT = "createdAt";

    public const UPDATED_AT = "updatedAt";
}