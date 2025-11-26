<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NameSliderApp;

class NameSliderAppController extends Controller
{
    public function index()
    {
        $sliders = NameSliderApp::all();

        return response()->json([
            'status' => true,
            'data' => $sliders
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();

            // Correct folder name
            $path = $image->storeAs('name_slider_app', $filename, 'public');

            $data['image'] = 'storage/' . $path;
        }

        $slider = NameSliderApp::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Slider added successfully',
            'data' => $slider
        ]);
    }

    public function destroy(NameSliderApp $slider)
    {
        if ($slider->image) {
            $imagePath = public_path($slider->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $slider->delete();

        return response()->json([
            'status' => true,
            'message' => 'Slider deleted successfully'
        ]);
    }
}
