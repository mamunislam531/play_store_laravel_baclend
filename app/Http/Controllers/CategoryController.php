<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            'status' => 'Success',
            'data' => $categories
        ], 200);
    }


    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name'  => 'required|string|max:255|unique:categories,name',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:4096'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('category_images', 'public');
        }

        $category = Category::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Category created successfully.',
            'data' => $category
        ], 201);
    }


    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Category not found or already deleted.'
            ], 404);
        }

        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Category not found or already deleted.'
            ], 404);
        }

        // Validation
        $data = $request->validate([
            'name'  => 'sometimes|string|max:255|unique:categories,name,' . $id,
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:4096'
        ]);

        // Upload Image
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('category_images', 'public');
        }

        // Update
        $category->update($data);

        return response()->json([
            'message' => 'Category updated successfully.',
            'data' => $category
        ]);
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Category not found or already deleted.'
            ], 404);
        }

        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully.'
        ]);
    }
}
