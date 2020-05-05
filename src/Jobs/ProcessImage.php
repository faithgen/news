<?php

namespace FaithGen\News\Jobs;

use FaithGen\News\Models\News;
use FaithGen\SDK\Traits\ProcessesImages;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\ImageManager;

class ProcessImage implements ShouldQueue
{
    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels,
        ProcessesImages;

    public bool $deleteWhenMissingModels = true;
    protected News $article;

    /**
     * Create a new job instance.
     *
     * @param News $article
     */
    public function __construct(News $article)
    {
        $this->article = $article;
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
        $this->processImage($imageManager, $this->article);
    }
}
