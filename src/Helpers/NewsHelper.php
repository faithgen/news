<?php


namespace FaithGen\News\Helpers;


use FaithGen\News\Models\News;
use FaithGen\SDK\Helpers\Helper;

class NewsHelper extends Helper
{
    public static function getAvatar(News $news)
    {
        dd($news->image);
        return [
            '_100' => asset('storage/news/100-100/' . $news->image->name),
           // 'original' => asset('storage/news/original/' . $news->image->name),
        ];
    }
}
