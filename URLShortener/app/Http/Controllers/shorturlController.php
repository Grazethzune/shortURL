<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\ShortUrl;

class shorturlController extends Controller
{
    public function shorten(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|url'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'URL tidak valid.'], 422);
        }

        $code = Str::random(6);

        ShortUrl::create([
            'original_url' => $request->url,
            'short_code' => $code
        ]);

        return response()->json(['short_url' => url($code)]);
    }

    public function redirect($code)
    {
        $short = ShortUrl::where('short_code', $code)->first();

        if (!$short) {
            return response()->json(['error' => 'URL tidak ditemukan.'], 404);
        }

        $short->increment('jumlah_akses');

        return redirect()->away($short->original_url, 302);
    }

    public function stats()
    {
        return response()->json(
            ShortUrl::select('original_url', 'short_code', 'jumlah_akses', 'created_at')
                ->orderByDesc('created_at')
                ->get()
        );
    }
}

