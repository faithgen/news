<?php

namespace FaithGen\News\Services;

use FaithGen\News\Models\News;
use FaithGen\SDK\Traits\FileTraits;
use InnoFlash\LaraStart\Services\CRUDServices;

class NewsService extends CRUDServices
{
    use FileTraits;
    /**
     * @var News
     */
    private $news;

    public function __construct(News $news)
    {
        if (request()->has('news_id')) {
            $this->news = News::findOrFail(request()->news_id);
        } else {
            $this->news = $news;
        }
    }

    /**
     * @return News
     */
    public function getNews(): News
    {
        return $this->news;
    }

    /**
     * This sets the attributes to be removed from the given set for updating or creating.
     * @return mixed
     */
    public function getUnsetFields(): array
    {
        return ['news_id', 'image'];
    }

    /**
     * This get the model value or class of the model in the service.
     * @return mixed
     */
    public function getModel()
    {
        return $this->getNews();
    }

    public function getParentRelationship()
    {
        return auth()->user()->news();
    }
}
