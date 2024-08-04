<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Services\GenerateLinkInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class LinkController extends Controller
{
    const WIN = 'Win';
    const LOSE = 'Lose';

    public function __construct(
        private GenerateLinkInterface $generateLink
    ){
    }

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
        $link = $this->generateLink->generateLink(Auth::user());

        return response()->json(['unique_link' => $link]);
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
            $winAmount = match (true) {
                $randomNumber > 900 => $randomNumber * 0.7,
                $randomNumber > 600 => $randomNumber * 0.5,
                $randomNumber > 300 => $randomNumber * 0.3,
                default => $randomNumber * 0.1,
            };
        }

        return response()->json([
            'number' => $randomNumber,
            'result' => $result,
            'winAmount' => $winAmount,
        ]);
    }
}
