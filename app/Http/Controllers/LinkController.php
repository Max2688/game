<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LinkController extends Controller
{
    const WIN = 'Win';
    const LOSE = 'Lose';

    public function index($unique_link)
    {
        $link = Link::where('unique_link', $unique_link)->firstOrFail();

        if (Carbon::now()->greaterThan($link->expires_at) || !$link->is_active) {
            abort(404);
        }

        return view('link', compact('link'));
    }

    public function generateLink()
    {
        $uniqueLink = Str::random(32);

        $link = Auth::user()->links()->create([
            'unique_link' => $uniqueLink,
            'expires_at' => Carbon::now()->addDays(7),
        ]);

        return response()->json(['unique_link' => $link->unique_link]);
    }

    public function deactivateLink(Request $request)
    {
        $link = Link::findOrFail($request->link_id);
        $link->is_active = false;
        $link->save();

        return response()->json(['message' => 'Link deactivated']);
    }

    public function imFeelingLucky()
    {
        $randomNumber = rand(1, 1000);
        $result = $randomNumber % 2 == 0 ? self::WIN : self::LOSE;
        $winAmount = 0;

        if ($result === self::WIN) {
            if ($randomNumber > 900) {
                $winAmount = $randomNumber * 0.7;
            } elseif ($randomNumber > 600) {
                $winAmount = $randomNumber * 0.5;
            } elseif ($randomNumber > 300) {
                $winAmount = $randomNumber * 0.3;
            } else {
                $winAmount = $randomNumber * 0.1;
            }
        }

        return response()->json([
            'number' => $randomNumber,
            'result' => $result,
            'winAmount' => $winAmount,
        ]);
    }
}
