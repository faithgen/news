<?php

namespace FaithGen\News\Observers\Ministry;

use App\Events\Ministry\News\Saved;
use FaithGen\News\Models\News;
use FaithGen\SDK\Traits\FileTraits;

class NewsObserver
{
    use FileTraits;
    /**
     * Handle the news "created" event.
     *
     * @param  \FaithGen\News\Models\News  $news
     * @return void
     */
    public function created(News $news)
    {
        event(new Saved($news));
    }

    /**
     * Handle the news "updated" event.
     *
     * @param  \FaithGen\News\Models\News  $news
     * @return void
     */
    public function updated(News $news)
    {
        //
    }

    /**
     * Handle the news "deleted" event.
     *
     * @param  \FaithGen\News\Models\News  $news
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
     * @param  \FaithGen\News\Models\News  $news
     * @return void
     */
    public function restored(News $news)
    {
        //
    }

    /**
     * Handle the news "force deleted" event.
     *
     * @param  \FaithGen\News\Models\News  $news
     * @return void
     */
    public function forceDeleted(News $news)
    {
        //
    }
}
