<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FavoriteQuotation;

class FavoriteQuotationController extends Controller
{
    // Add favorite
    public function store(Request $request)
    {
        $data = $request->validate([
            'device_id' => 'required|string',
            'quotation_id' => 'required|exists:quotations,id'
        ]);

        $favorite = FavoriteQuotation::firstOrCreate([
            'device_id' => $data['device_id'],
            'quotation_id' => $data['quotation_id']
        ]);

        return response()->json([
            'status' => 'Success',
            'data' => $favorite
        ]);
    }

 
    public function index($device_id)
    {
        $quotations = FavoriteQuotation::with('quotation')
            ->where('device_id', $device_id)
            ->get()
            ->pluck('quotation'); // শুধুমাত্র quotation field নেবে

        if ($quotations->isEmpty()) {
            return response()->json([
                'status' => 'Error',
                'message' => 'No favorite quotations found'
            ], 404);
        }

        return response()->json([
            'status' => 'Success',
            'data' => $quotations
        ]);
    }


    // Remove favorite
    public function destroy(Request $request)
    {
        $data = $request->validate([
            'device_id' => 'required|string',
            'quotation_id' => 'required|exists:quotations,id'
        ]);

        $favorite = FavoriteQuotation::where([
            'device_id' => $data['device_id'],
            'quotation_id' => $data['quotation_id']
        ])->first();

        if (!$favorite) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Favorite not found'
            ], 404);
        }

        $favorite->delete();

        return response()->json([
            'status' => 'Success',
            'message' => 'Favorite removed'
        ]);
    }
}
