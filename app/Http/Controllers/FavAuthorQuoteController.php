<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FavAuthorQuote;

class FavAuthorQuoteController extends Controller
{
    // GET /api/fav-author-quote?device_id=xxxx
    public function index(Request $request)
    {
        $request->validate([
            'device_id' => 'required|string',
        ]);

        $favorites = FavAuthorQuote::with('quote.author')
            ->where('device_id', $request->device_id)
            ->get();

        $result = $favorites->map(function($item) {
            return [
                'id' => $item->id,
                'device_id' => $item->device_id,
                'quote_id' => $item->quote_id,
                'quote' => $item->quote->quote ?? null,
                'author_name' => $item->quote->author->name ?? null,
                'author_bio' => $item->quote->author->bio ?? null,
            ];
        });

        return response()->json($result);
    }

    // POST /api/fav-author-quote
    public function store(Request $request)
    {
        $data = $request->validate([
            'device_id' => 'required|string',
            'quote_id' => 'required|exists:author_quotes,id',
        ]);

        $favorite = FavAuthorQuote::firstOrCreate($data);

        return response()->json([
            'message' => 'Quote added to favorites',
            'favorite' => $favorite
        ]);
    }

    // DELETE /api/fav-author-quote
    public function destroy(Request $request)
    {
        $data = $request->validate([
            'device_id' => 'required|string',
            'quote_id' => 'required|exists:author_quotes,id',
        ]);

        $favorite = FavAuthorQuote::where($data)->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['message' => 'Quote removed from favorites']);
        }

        return response()->json(['message' => 'Favorite not found'], 404);
    }
}
