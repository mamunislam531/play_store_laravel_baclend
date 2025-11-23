<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Quotation;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    // Get all quotations
    public function index()
    {
        $quotations = Quotation::all();
        return response()->json([
            'status' => 'Success',
            'data' => $quotations
        ]);
    }

    // Store new quotation
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'quote'       => 'required|string',
            'author'      => 'nullable|string|max:255'
        ]);

        $quotation = Quotation::create($data);

        return response()->json([
            'status' => 'Success',
            'data' => $quotation
        ], 201);
    }

    // Show single quotation
    // public function show($id)
    // {
    //     $quotation = Quotation::find($id);
    //     if (!$quotation) return response()->json(['status' => 'Error', 'message' => 'Quotation not found'], 404);

    //     return response()->json(['status' => 'Success', 'data' => $quotation]);
    // }

    public function show($category_id)
{
    $quotations = Quotation::where('category_id', $category_id)->get();

    if ($quotations->isEmpty()) {
        return response()->json([
            'status' => 'Error',
            'message' => 'No quotations found for this category'
        ], 404);
    }

    return response()->json([
        'status' => 'Success',
        'data' => $quotations
    ]);
}


    // Update quotation
    public function update(Request $request, $id)
    {
        $quotation = Quotation::find($id);
        if (!$quotation) return response()->json(['status' => 'Error', 'message' => 'Quotation not found'], 404);

        $data = $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'quote'       => 'sometimes|string',
            'author'      => 'nullable|string|max:255'
        ]);

        $quotation->update($data);

        return response()->json(['status' => 'Success', 'data' => $quotation]);
    }

    // Delete quotation
    public function destroy($id)
    {
        $quotation = Quotation::find($id);
        if (!$quotation) return response()->json(['status' => 'Error', 'message' => 'Quotation not found'], 404);

        $quotation->delete();

        return response()->json(['status' => 'Success', 'message' => 'Quotation deleted successfully']);
    }

    public function bulkAdd(Request $request)
    {
        $data = $request->validate([
            'quotations' => 'required|array',
            'quotations.*.category_id' => 'required|exists:categories,id',
            'quotations.*.quote' => 'required|string',
            'quotations.*.author' => 'nullable|string|max:255'
        ]);

        DB::table('quotations')->insert($data['quotations']);

        return response()->json([
            'status' => 'Success',
            'message' => 'Bulk insert completed',
            'inserted_count' => count($data['quotations'])
        ]);
    }
}
