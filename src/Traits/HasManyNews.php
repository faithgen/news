<?php


namespace FaithGen\News\Traits;


use FaithGen\News\Models\News;

trait HasManyNews
{
    /**
     * Links many news items to a given model
     *
     * @return mixed
     */
    public function news()
    {
        return $this->hasMany(News::class);
    }
}
