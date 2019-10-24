<?php


namespace FaithGen\News\Helpers;


use App\Models\Ministry\News;
use FaithGen\SDK\Helpers\Helper;

class NewsHelper extends Helper
{
    public static function getAvatar(News $news)
    {
        return [
            '_100' => asset('storage/news/100-100/' . $news->image->name),
            'original' => asset('storage/news/original/' . $news->image->name),
        ];
    }
}
