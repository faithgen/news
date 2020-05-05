<?php

namespace FaithGen\News\Jobs;

use FaithGen\News\Models\News;
use FaithGen\SDK\Traits\UploadsImages;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\ImageManager;

class UploadImage implements ShouldQueue
{
    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels,
        UploadsImages;

    public bool $deleteWhenMissingModels = true;
    protected News $article;

    protected $image;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(News $article, $image)
    {
        $this->article = $article;
        $this->image = $image;
    }

    /**
     * Execute the job.
     *
     * @param ImageManager $imageManager
     *
     * @return void
     */
    public function handle(ImageManager $imageManager)
    {
        $this->uploadImages($this->article, [$this->image], $imageManager);
    }
}
