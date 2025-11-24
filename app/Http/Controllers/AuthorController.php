<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AuthorController extends Controller
{
    // Get all authors
    public function index()
    {
        return Author::all();
    }

    // Store new author
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:authors,name',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048', // max 2MB
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('authors', $filename, 'public');
            $data['image'] = $path;
        }

        $author = Author::create($data);

        return response()->json([
            'message' => 'Author created successfully',
            'author' => $author
        ], 201);
    }

    // Show single author
    public function show($id)
    {
        $author = Author::findOrFail($id);
        return response()->json($author);
    }

    // Update author
    public function update(Request $request, $id)
    {
        $author = Author::findOrFail($id);

        $data = $request->validate([
            'name' => ['required', 'string', Rule::unique('authors')->ignore($author->id)],
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($author->image && Storage::disk('public')->exists($author->image)) {
                Storage::disk('public')->delete($author->image);
            }

            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('authors', $filename, 'public');
            $data['image'] = $path;
        }

        $author->update($data);

        return response()->json([
            'message' => 'Author updated successfully',
            'author' => $author
        ]);
    }

    // Delete author
    public function destroy($id)
    {
        $author = Author::findOrFail($id);

        // Delete image if exists
        if ($author->image && Storage::disk('public')->exists($author->image)) {
            Storage::disk('public')->delete($author->image);
        }

        $author->delete();

        return response()->json(['message' => 'Author deleted successfully']);
    }
}
