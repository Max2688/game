<?php

namespace App\Listeners;

use App\Services\Game\GenerateLink;
use Illuminate\Auth\Events\Registered;

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
