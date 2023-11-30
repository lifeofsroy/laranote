<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::where('user_id', auth()->id())->paginate(8);

        return view("pages.notes.index", [
            "notes" => $notes
        ]);
    }

    public function add()
    {
        return view("pages.notes.add");
    }

    public function create(Request $request)
    {
        $request->validate([
            "title" => ['required'],
            "overview" => ['required'],
            "description" => ['required'],
        ]);

        Note::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'overview' => $request->overview,
            'description' => $request->description
        ]);

        return response()->json(['message' => 'Note Added Successfully']);
    }

    public function edit($id)
    {
        $note = Note::where('user_id', auth()->id())->find($id);

        return view("pages.notes.edit", [
            "note" => $note
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "title" => ['required'],
            "overview" => ['required'],
            "description" => ['required'],
        ]);

        $note = Note::where('user_id', auth()->id())->find($id);

        $note->update([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'overview' => $request->overview,
            'description' => $request->description
        ]);

        return response()->json(['message' => 'Note Updated Successfully']);
    }

    public function delete($id)
    {
        $note = Note::where('user_id', auth()->id())->find($id);
        $note->delete();

        return response()->json(['noteid' => $note->id, 'message' => 'Note Deleted Successfully']);
    }

    public function show($id)
    {
        $note = Note::where('user_id', auth()->id())->find($id);

        return view('pages.notes.show', [
            'note' => $note
        ]);
    }

    public function status($id)
    {
        $note = Note::where('user_id', auth()->id())->find($id);

        if ($note->is_active == 1) {
             $status = 0;
        } else {
            $status = 1;
        }

        $note->update(['is_active' => $status]);

        return response()->json(['message' => 'Status Updated Successfully']);
    }
}
