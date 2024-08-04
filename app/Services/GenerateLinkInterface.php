<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

interface GenerateLinkInterface
{
    public function generateLink(User|Authenticatable $user): string;
}
