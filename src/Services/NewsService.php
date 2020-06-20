<?php

namespace FaithGen\News\Services;

use FaithGen\News\Models\News;
use InnoFlash\LaraStart\Services\CRUDServices;

class NewsService extends CRUDServices
{
    /**
     * @var News
     */
    protected News $news;

    public function __construct()
    {
        $this->news = app(News::class);

        $newsId = request()->route('news') ?? request('news_id');

        if ($newsId) {
            $this->news = $this->news->resolveRouteBinding($newsId);
        }
    }

    /**
     * Retrieves an instance of news.
     *
     * @return \FaithGen\News\Models\News
     */
    public function getNews(): News
    {
        return $this->news;
    }

    /**
     * Makes a list of fields that you do not want to be sent
     * to the create or update methods.
     * Its mainly the fields that you do not have in the messages table.
     *
     * @return array
     */
    public function getUnsetFields(): array
    {
        return ['news_id'];
    }

    public function getParentRelationship()
    {
        return auth()->user()->news();
    }
}
