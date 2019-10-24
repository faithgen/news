<?php

namespace FaithGen\News\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \FaithGen\News\Events\Saved::class => [
            \FaithGen\News\Listeners\Saved\UploadImage::class,
            \FaithGen\News\Listeners\Saved\ProcessImage::class,
            \FaithGen\News\Listeners\Saved\MessageFollowUsers::class,
            \FaithGen\News\Listeners\Saved\S3Upload::class,
        ],
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
