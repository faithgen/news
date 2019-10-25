<?php

namespace FaithGen\News\Policies;

use FaithGen\News\Helpers\NewsHelper;
use FaithGen\News\Models\News;
use Carbon\Carbon;
use FaithGen\SDK\Models\Ministry;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any news.
     *
     * @param \App\Models\Ministry $user
     * @return mixed
     */
    public function viewAny(Ministry $user)
    {
        //
    }

    /**
     * Determine whether the user can view the news.
     *
     * @param Ministry $user
     * @param News $news
     * @return mixed
     */
    public static function view(Ministry $user, News $news)
    {
        return $user->id === $news->ministry_id;
    }

    /**
     * Determine whether the user can create news.
     *
     * @param Ministry $user
     * @return mixed
     */
    public static function create(Ministry $user)
    {
        if ($user->account->level !== 'Free')
            return true;
        else {
            $newsCount = News::where('ministry_id', $user->id)->whereBetween('created_at', [Carbon::now()->firstOfMonth(), Carbon::now()->lastOfMonth()])->count();
            if ($newsCount >= NewsHelper::$freeNewsCount)
                return false;
            else
                return true;
        }
    }

    /**
     * Determine whether the user can update the news.
     *
     * @param \App\Models\Ministry $user
     * @param News $news
     * @return mixed
     */
    public static function update(Ministry $user, News $news)
    {
        return $user->id === $news->ministry_id;
    }

    /**
     * Determine whether the user can delete the news.
     *
     * @param \App\Models\Ministry $user
     * @param News $news
     * @return mixed
     */
    public static function delete(Ministry $user, News $news)
    {
        return $user->id === $news->ministry_id;
    }
}
