<?php

namespace FaithGen\News\Providers;

use FaithGen\News\Models\News;
use FaithGen\News\Observers\Ministry\NewsObserver;
use Illuminate\Support\Facades\Route;
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
        $this->mergeConfigFrom(__DIR__.'/../config/faithgen-news.php', 'faithgen-news');
        $this->registerRoutes();

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../storage/news/' => storage_path('app/public/news')
            ], 'faithgen-news-storage');

            $this->publishes([
                __DIR__ . '/../database/migrations/' => database_path('migrations')
            ], 'faithgen-news-migrations');

            $this->publishes([
                __DIR__ . '/../config/faithgen-news.php' => config_path('faithgen-news.php')
            ], 'faithgen-news-config');
        }

        News::observe(NewsObserver::class);
    }

    private function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {

            $this->loadRoutesFrom(__DIR__ . '/../routes/news.php');
        });
    }

    private function routeConfiguration()
    {
        return [
            'prefix' => config('faithgen-news.prefix'),
            'namespace' => "FaithGen\News\Http\Controllers",
            'middleware' => config('faithgen-news.middlewares'),
        ];
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
