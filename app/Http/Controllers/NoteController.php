<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;

class NoteController extends Controller
{
    // Get all notes
    public function index() {
        $notes = Note::orderBy('created_at','desc')->get();
        return response()->json(['success'=>true, 'notes'=>$notes]);
    }

    // Add note
    public function store(Request $request) {
        // Validate empty note
        $request->validate([
            'note' => 'required|string|min:1'
        ], [
            'note.required' => 'Note field cannot be empty',
            'note.min' => 'Note cannot be empty'
        ]);

        $note = Note::create(['note'=>$request->note]);
        return response()->json([
            'success'=>true,
            'message'=>'Note added successfully',
            'note'=>$note
        ]);
    }

    // Update note
// Update note
public function update(Request $request, $id) {
    $request->validate([
        'note' => 'required|string|min:1'
    ], [
        'note.required' => 'Note field cannot be empty',
        'note.min' => 'Note cannot be empty'
    ]);

    $note = Note::find($id);
    if(!$note){
        return response()->json([
            'success' => false,
            'message' => "Data not found or Already Deleted"
        ], 404);
    }

    $note->update(['note'=>$request->note]);
    return response()->json([
        'success' => true,
        'message' => 'Note updated successfully',
        'note' => $note
    ]);
}

// Delete note
public function destroy($id) {
    $note = Note::find($id);
    if(!$note){
        return response()->json([
            'success' => false,
            'message' => "Data not found or Already Deleted"
        ], 404);
    }

    $note->delete();
    return response()->json([
        'success' => true,
        'message' => 'Note deleted successfully'
    ]);
}

}
