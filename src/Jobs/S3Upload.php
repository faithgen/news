<?php

namespace FaithGen\News\Jobs;

use FaithGen\News\Models\News;
use FaithGen\SDK\Traits\SavesToAmazonS3;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class S3Upload implements ShouldQueue
{
    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels,
        SavesToAmazonS3;

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
     * @return void
     */
    public function handle()
    {
        $this->saveFiles($this->article);
    }
}
