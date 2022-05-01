<?php

namespace App\Dto;

use App\Model\CategoryModel;
use Hyperf\Di\Annotation\Inject;


class CategoryDto
{
    #[Inject]
    protected CategoryModel $categoryModel;

    public  function categeoryList()
    {
        return $this->categoryModel->newQuery()->get();
    }

}