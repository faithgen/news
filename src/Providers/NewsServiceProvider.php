<?php

namespace FaithGen\News\Providers;

use FaithGen\News\Models\News;
use FaithGen\News\Observers\Ministry\NewsObserver;
use Illuminate\Support\ServiceProvider;

class NewsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../storage/news/' => storage_path('app/public/news')
            ], 'faithgen-news-storage');
        }

        News::observe(NewsObserver::class);
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
