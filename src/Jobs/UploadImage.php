<?php

namespace FaithGen\News\Jobs;

use FaithGen\News\Models\News;
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
        SerializesModels;

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
        if ($this->image) {
            $fileName = str_shuffle($this->article->id.time().time()).'.png';
            $ogSave = storage_path('app/public/news/original/').$fileName;
            $imageManager->make($this->image)->save($ogSave);
            $this->article->image()->updateOrcreate([
                'imageable_id' => $this->article->id,
            ], [
                'name' => $fileName,
            ]);
        }
    }
}
