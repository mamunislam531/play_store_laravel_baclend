<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FavAuthorQuote;
use App\Models\AuthorQuote;

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

        $result = $favorites->map(function ($item) {
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

    public function slider()
    {

        $quotations = AuthorQuote::inRandomOrder()->take(10)->get();


        if ($quotations->isEmpty()) {
            return response()->json([
                'status' => 'Error',
                'message' => 'No quotations found'
            ], 404);
        }

        // Format response
        $data = $quotations->map(function ($quote) {
            return [
                'id' => $quote->id,
                'author_id' => $quote->author_id,
                'author_name' => $quote->author ? $quote->author->name : null,
                'quote' => $quote->quote,
                'created_at' => $quote->created_at,
                'updated_at' => $quote->updated_at,
            ];
        });

        return response()->json([
            'status' => 'Success',
            'data' => $data
        ]);
    }
}
