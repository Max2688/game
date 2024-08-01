<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'unique_link',
        'expires_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
