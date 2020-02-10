<?php

namespace FaithGen\News\Listeners\Saved;


use FaithGen\News\Events\Saved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class S3Upload implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Saved  $event
     * @return void
     */
    public function handle(Saved $event)
    {
        //
    }
}
