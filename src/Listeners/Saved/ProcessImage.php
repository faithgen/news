<?php

namespace FaithGen\News\Listeners\Saved;

use FaithGen\News\Events\Saved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Intervention\Image\ImageManager;

class ProcessImage implements ShouldQueue
{
    /**
     * @var ImageManager
     */
    private $imageManager;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    /**
     * Handle the event.
     *
     * @param Saved $event
     * @return void
     */
    public function handle(Saved $event)
    {
        if ($event->getNews()->image()->exists()) {
            $ogImage = storage_path('app/public/news/original/') . $event->getNews()->image->name;
            $thumb100 = storage_path('app/public/news/100-100/') . $event->getNews()->image->name;

            $this->imageManager->make($ogImage)->fit(100, 100, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            }, 'center')->save($thumb100);
        }
    }
}
