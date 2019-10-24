<?php

namespace FaithGen\News\Listeners\Saved;

use FaithGen\News\Events\Saved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Intervention\Image\ImageManager;

class UploadImage
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
     * @param  Saved  $event
     * @return void
     */
    public function handle(Saved $event)
    {
        if (request()->has('image')) {
            $fileName = str_shuffle($event->getNews()->id . time() . time()) . '.png';
            $ogSave = storage_path('app/public/news/original/') . $fileName;
            $this->imageManager->make(request()->image)->save($ogSave);
            $event->getNews()->image()->updateOrcreate([
                'imageable_id' => $event->getNews()->id
            ], [
                'name' => $fileName
            ]);
        }
    }
}
