<?php

namespace App\Services;

use App\Models\News;
use App\Repositories\NewsRepository;

/**
 * Class NewsService.
 */
class NewsService
{
    private $newsRepos;

    public function __construct(NewsRepository $newsRepos)
    {
        $this->newsRepos = $newsRepos;
    }

    public function getOneNews()
    {
        $news = $this->newsRepos->getOneNews();
        return $news;
    }
}
