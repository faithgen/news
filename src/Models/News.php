<?php

namespace FaithGen\News\Models;

use FaithGen\SDK\Traits\Relationships\Belongs\BelongsToMinistryTrait;
use FaithGen\SDK\Traits\Relationships\Morphs\CommentableTrait;
use FaithGen\SDK\Traits\Relationships\Morphs\ImageableTrait;
use FaithGen\SDK\Models\UuidModel;
use FaithGen\SDK\Traits\StorageTrait;

class News extends UuidModel
{
    use ImageableTrait, CommentableTrait, BelongsToMinistryTrait, StorageTrait;

    protected $table = 'news';

    //****************************************************************************//
    //***************************** MODEL ATTRIBUTES *****************************//
    //****************************************************************************//
    function getTitleAttribute($val)
    {
        return ucfirst($val);
    }

    //****************************************************************************//
    //***************************** MODEL RELATIONSHIPS *****************************//
    //****************************************************************************//


    /**
     * The name of the directory in storage that has files for this model
     * @return mixed
     */
    function filesDir()
    {
        return 'news';
    }

    /**
     * The file name fo this model
     * @return mixed
     */
    function getFileName()
    {
        return $this->image->name;
    }

    public function getImageDimensions()
    {
        return [0, 100];
    }
}

