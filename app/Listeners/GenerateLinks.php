<?php

namespace App\Listeners;

use App\Services\GenerateLink;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class GenerateLinks
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(
        private GenerateLink $generateLink
    ){
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $this->generateLink->generateLink($event->user);
    }
}
