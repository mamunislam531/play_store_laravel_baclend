<?php

namespace App\Http\Controllers;

use App\Models\NamesList;
use Illuminate\Http\Request;

class NamesListController extends Controller
{
    // Add new name
    public function store(Request $request)
    {
        $data = $request->validate([
            'religion_id' => 'required|exists:religions,id',
            'gender' => 'required|in:Boy,Girl',
            'name_bn' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'bn_meaning' => 'nullable|string',
        ]);

        $name = NamesList::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Name added successfully',
            'data' => $name
        ]);
    }

    // Show all names
    public function index()
    {
        $names = NamesList::with('religion')->get();

        return response()->json([
            'status' => true,
            'data' => $names
        ]);
    }

    // Get names by religion
    public function byReligion($id)
    {
        $names = NamesList::where('religion_id', $id)->get();

        return response()->json([
            'status' => true,
            'data' => $names
        ]);
    }

    public function byReligionAndGender($id, $gender)
    {
        if (!in_array($gender, ['Boy', 'Girl'])) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid gender. Use Boy or Girl.'
            ], 400);
        }

        $names = NamesList::where('religion_id', $id)
            ->where('gender', $gender)
            ->get()
            ->map(function ($name) {
                return [
                    'id' => $name->id,
                    'religion_id' => $name->religion_id,
                    'religion' => $name->religion ? $name->religion->title : null,
                    'gender' => $name->gender,
                    'name_bn' => $name->name_bn,
                    'name_en' => $name->name_en,
                    'bn_meaning' => $name->bn_meaning,
                    'created_at' => $name->created_at,
                    'updated_at' => $name->updated_at,
                ];
            });

        return response()->json([
            'status' => true,
            'data' => $names
        ]);
    }

    public function bulkStore(Request $request)
{
    $data = $request->validate([
        '*.religion_id' => 'required|exists:religions,id',
        '*.gender' => 'required|in:Boy,Girl',
        '*.name_bn' => 'required|string|max:255',
        '*.name_en' => 'required|string|max:255',
        '*.bn_meaning' => 'nullable|string',
    ]);

    $inserted = [];
    foreach ($data as $item) {
        $inserted[] = NamesList::create($item);
    }

    // শুধু title হিসেবে religion দেখাতে চাইলে
    $inserted = collect($inserted)->map(function ($name) {
        return [
            'id' => $name->id,
            'religion_id' => $name->religion_id,
            'religion' => $name->religion ? $name->religion->title : null,
            'gender' => $name->gender,
            'name_bn' => $name->name_bn,
            'name_en' => $name->name_en,
            'bn_meaning' => $name->bn_meaning,
            'created_at' => $name->created_at,
            'updated_at' => $name->updated_at,
        ];
    });

    return response()->json([
        'status' => true,
        'message' => 'Names added successfully',
        'data' => $inserted
    ]);
}

}
