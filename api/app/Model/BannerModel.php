<?php

namespace App\Model;

class BannerModel extends Model
{
    /**
     * @var string
     */
    protected $table = "a_banner";

    /**
     * @var string[]
     */
    protected $fillable = [
        "imgUrl", "desc",
    ];
    public const CREATED_AT = "createdAt";

    public const UPDATED_AT = "updatedAt";



}