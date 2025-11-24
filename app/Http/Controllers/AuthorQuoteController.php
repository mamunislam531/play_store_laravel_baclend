<?php

namespace App\Http\Controllers;

use App\Models\AuthorQuote;
use Illuminate\Http\Request;

class AuthorQuoteController extends Controller
{
    public function index()
    {
        return AuthorQuote::with('author')->latest()->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'author_id' => 'required|exists:authors,id',
            'quote'     => 'required|string',
        ]);

        return AuthorQuote::create($data);
    }

    public function show($id)
    {
        return AuthorQuote::with('author')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $quote = AuthorQuote::findOrFail($id);

        $data = $request->validate([
            'author_id' => 'required|exists:authors,id',
            'quote'     => 'required|string',
        ]);

        $quote->update($data);

        return $quote;
    }

    public function destroy($id)
    {
        $quote = AuthorQuote::findOrFail($id);
        $quote->delete();

        return response()->json(['message' => 'Quote deleted successfully']);
    }

    public function bulkAdd(Request $request)
{
    $data = $request->validate([
        'quotes' => 'required|array',
        'quotes.*.author_id' => 'required|exists:authors,id',
        'quotes.*.quote' => 'required|string',
    ]);

    $insertData = collect($data['quotes'])->map(function ($item) {
        return [
            'author_id' => $item['author_id'],
            'quote' => $item['quote'],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    })->toArray();

    AuthorQuote::insert($insertData);

    return response()->json([
        'message' => 'Quotes added successfully',
        'count' => count($insertData)
    ]);
}

}
