<?php

namespace App\Repositories;

use App\Dto\CategoryDto;
use Hyperf\Di\Annotation\Inject;

class CategoryRepositories
{
    #[Inject]
    protected CategoryDto $categoryDto;

    public function categoryList()
    {
        return $this->categoryDto->categeoryList();
    }

}