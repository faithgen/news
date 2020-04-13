<?php

namespace FaithGen\News\Providers;

use FaithGen\News\Models\News;
use FaithGen\News\Observers\NewsObserver;
use FaithGen\News\Services\NewsService;
use FaithGen\SDK\Traits\ConfigTrait;
use Illuminate\Support\ServiceProvider;

class NewsServiceProvider extends ServiceProvider
{
    use ConfigTrait;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRoutes(__DIR__.'/../../routes/news.php', __DIR__.'/../../routes/source.php');

        $this->setUpSourceFiles(function () {
            $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

            $this->publishes([
                __DIR__.'/../../storage/news/' => storage_path('app/public/news'),
            ], 'faithgen-news-storage');

            $this->publishes([
                __DIR__.'/../../database/migrations/' => database_path('migrations'),
            ], 'faithgen-news-migrations');
        });

        $this->publishes([
            __DIR__.'/../../config/faithgen-news.php' => config_path('faithgen-news.php'),
        ], 'faithgen-news-config');

        News::observe(NewsObserver::class);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/faithgen-news.php', 'faithgen-news');

        $this->app->singleton(NewsService::class);
    }

    /**
     * The config you want to be applied onto your routes.
     * @return array the rules eg, middleware, prefix, namespace
     */
    public function routeConfiguration(): array
    {
        return [
            'prefix' => config('faithgen-news.prefix'),
            'middleware' => config('faithgen-news.middlewares'),
        ];
    }
}
