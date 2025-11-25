<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Religion;
use Illuminate\Support\Str;

class ReligionController extends Controller
{
public function index()
{
    $religions = Religion::all(); // fetch all religions

    return response()->json([
        'status' => true,
        'data' => $religions
    ]);
}
    // Store new religion with image upload
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'img' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        // Handle image upload
        // if ($request->hasFile('img')) {
        //     $image = $request->file('img');
        //     $name = Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME));
        //     $ext = $image->getClientOriginalExtension();
        //     $filename = $name . '_' . time() . '.' . $ext;
        //     $image->move(public_path('religions'), $filename);
        //     $data['img'] = 'religions/' . $filename;
        // }


            // Handle image upload
        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $filename = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('religions', $filename, 'public');
            $data['img'] = $path;
        }
        $religion = Religion::create($data);

        return response()->json([
            'message' => 'Religion created successfully',
            'religion' => $religion
        ], 201);
    }

    // Show single religion
    public function show(Religion $religion)
    {
        return response()->json($religion);
    }

    // Update religion
    public function update(Request $request, Religion $religion)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'img' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        if ($request->hasFile('img')) {
            // Delete old image
            if ($religion->img && file_exists(public_path($religion->img))) {
                unlink(public_path($religion->img));
            }

            $image = $request->file('img');
            $name = Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME));
            $ext = $image->getClientOriginalExtension();
            $filename = $name . '_' . time() . '.' . $ext;
            $image->move(public_path('religions'), $filename);
            $data['img'] = 'religions/' . $filename;
        }

        $religion->update($data);

        return response()->json([
            'message' => 'Religion updated successfully',
            'religion' => $religion
        ]);
    }

    // Delete religion
    public function destroy(Religion $religion)
    {
        if ($religion->img && file_exists(public_path($religion->img))) {
            unlink(public_path($religion->img));
        }

        $religion->delete();

        return response()->json([
            'message' => 'Religion deleted successfully'
        ]);
    }
}
