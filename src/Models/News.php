<?php

namespace FaithGen\News\Models;

use FaithGen\SDK\Models\UuidModel;
use FaithGen\SDK\Traits\Relationships\Belongs\BelongsToMinistryTrait;
use FaithGen\SDK\Traits\Relationships\Morphs\CommentableTrait;
use FaithGen\SDK\Traits\Relationships\Morphs\ImageableTrait;
use FaithGen\SDK\Traits\StorageTrait;
use FaithGen\SDK\Traits\TitleTrait;

class News extends UuidModel
{
    use ImageableTrait, CommentableTrait, BelongsToMinistryTrait, StorageTrait, TitleTrait;

    protected $table = 'news';

    //****************************************************************************//
    //***************************** MODEL ATTRIBUTES *****************************//
    //****************************************************************************//
    public function getTitleAttribute($val)
    {
        return ucfirst($val);
    }

    //****************************************************************************//
    //***************************** MODEL RELATIONSHIPS *****************************//
    //****************************************************************************//

    /**
     * The name of the directory in storage that has files for this model.
     * @return mixed
     */
    public function filesDir()
    {
        return 'news';
    }

    /**
     * The file name fo this model.
     * @return mixed
     */
    public function getFileName()
    {
        return $this->image->name;
    }

    public function getImageDimensions()
    {
        return [0, 100];
    }
}
