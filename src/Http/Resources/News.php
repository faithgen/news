<?php

namespace FaithGen\News\Http\Resources;

use FaithGen\News\Helpers\NewsHelper;
use Illuminate\Http\Resources\Json\JsonResource;
use InnoFlash\LaraStart\Helper;

class News extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'date' => Helper::getDates($this->created_at),
            'avatar' => NewsHelper::getAvatar($this->resource),
            'comments' => [
                'count' => $this->comments()->count()
            ],
            'news' => $this->news
        ];
    }
}
