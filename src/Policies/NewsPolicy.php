<?php

namespace FaithGen\News\Policies;

use FaithGen\SDK\Helpers\Helper;
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
     * @param \App\Models\Ministry $user
     * @param \FaithGen\News\Models\News $news
     * @return mixed
     */
    public function view(Ministry $user, News $news)
    {
        return $user->id === $news->ministry_id;
    }

    /**
     * Determine whether the user can create news.
     *
     * @param \App\Models\Ministry $user
     * @return mixed
     */
    public function create(Ministry $user)
    {
        if ($user->account->level !== 'Free')
            return true;
        else {
            $sermonsCount = News::whereBetween('created_at', [Carbon::now()->firstOfMonth(), Carbon::now()->lastOfMonth()])->count();
            if ($sermonsCount >= Helper::$freeNewsCount)
                return false;
            else
                return true;
        }
    }

    /**
     * Determine whether the user can update the news.
     *
     * @param \App\Models\Ministry $user
     * @param \FaithGen\News\Models\News $news
     * @return mixed
     */
    public function update(Ministry $user, News $news)
    {
        return $user->id === $news->ministry_id;
    }

    /**
     * Determine whether the user can delete the news.
     *
     * @param \App\Models\Ministry $user
     * @param \FaithGen\News\Models\News $news
     * @return mixed
     */
    public function delete(Ministry $user, News $news)
    {
        return $user->id === $news->ministry_id;
    }
}
