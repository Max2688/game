<?php

namespace App\Services;

use App\Models\Link;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class GenerateLink
{
    public function generateLink(User|Authenticatable $user): string
    {
        $uniqueLink = Str::random(32);

        $link = $user->links()->create([
            'unique_link' => $uniqueLink,
            'expires_at' => Carbon::now()->addDays(7),
        ]);

        return $link->unique_link;
    }
}
