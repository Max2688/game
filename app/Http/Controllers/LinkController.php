<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Services\Game\GenerateLinkInterface;
use App\Services\Game\ValueObjects\WinResult;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class LinkController extends Controller
{
    public function __construct(
        private GenerateLinkInterface $service
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
        $link = $this->service->generateLink(Auth::user());

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

        $winResult = new WinResult($randomNumber);

        return response()->json([
            'number' => $winResult->getRandomNumber(),
            'result' => $winResult->getResult(),
            'winAmount' => $winResult->getWinAmount(),
        ]);
    }
}
