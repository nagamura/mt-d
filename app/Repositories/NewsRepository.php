<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model
use App\Models\News;

/**
 * Class NewsRepository.
 */
class NewsRepository extends BaseRepository
{
    private $newsModel;
    
    public function __construct(News $newsModel)
    {
        $this->newsModel = $newsModel;
    }
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        //return YourModel::class;
    }

    public function getOneNews()
    {
        $news = $this->newsModel::latest()->first();
        return $news;
    }
}
