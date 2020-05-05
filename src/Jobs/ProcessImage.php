<?php

namespace FaithGen\News\Jobs;

use FaithGen\News\Models\News;
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
        SerializesModels;

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
        if ($this->article->image()->exists()) {
            $ogImage = storage_path('app/public/news/original/').$this->article->image->name;
            $thumb100 = storage_path('app/public/news/100-100/').$this->article->image->name;

            $imageManager->make($ogImage)->fit(100, 100, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            }, 'center')->save($thumb100);
        }
    }
}
