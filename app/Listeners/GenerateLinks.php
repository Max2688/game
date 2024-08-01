<?php

namespace App\Listeners;

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
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $uniqueLink = Str::random(32);

        $event->user->links()->create([
            'unique_link' => $uniqueLink,
            'expires_at' => Carbon::now()->addDays(7),
        ]);

    }
}
