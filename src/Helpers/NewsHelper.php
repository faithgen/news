<?php


namespace FaithGen\News\Helpers;


use FaithGen\News\Models\News;
use FaithGen\SDK\Helpers\Helper;
use FaithGen\SDK\SDK;

class NewsHelper extends Helper
{
    public static $freeNewsCount = 2;

    public static function getAvatar(News $news)
    {
        return [
            '_100' => SDK::getAsset('storage/news/100-100/' . $news->image->name),
            'original' => SDK::getAsset('storage/news/original/' . $news->image->name),
        ];
    }
}
