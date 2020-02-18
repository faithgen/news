<?php

namespace FaithGen\News\Observers\Ministry;

use FaithGen\News\Jobs\MessageFollowers;
use FaithGen\News\Jobs\ProcessImage;
use FaithGen\News\Jobs\S3Upload;
use FaithGen\News\Jobs\UploadImage;
use FaithGen\News\Models\News;
use FaithGen\SDK\Traits\FileTraits;

class NewsObserver
{
    use FileTraits;
    /**
     * Handle the news "created" event.
     *
     * @param News $news
     * @return void
     */
    public function created(News $news)
    {
        MessageFollowers::withChain([
            new UploadImage($news, request('image')),
            new ProcessImage($news),
            new S3Upload($news)
        ])
            ->dispatch($news);
    }

    /**
     * Handle the news "updated" event.
     *
     * @param News $news
     * @return void
     */
    public function updated(News $news)
    {
        //
    }

    /**
     * Handle the news "deleted" event.
     *
     * @param News $news
     * @return void
     */
    public function deleted(News $news)
    {
        if ($news->image()->exists()) {
            $this->deleteFiles($news);
            $news->image()->delete();
        }
    }

    /**
     * Handle the news "restored" event.
     *
     * @param News $news
     * @return void
     */
    public function restored(News $news)
    {
        //
    }

    /**
     * Handle the news "force deleted" event.
     *
     * @param News $news
     * @return void
     */
    public function forceDeleted(News $news)
    {
        //
    }
}
