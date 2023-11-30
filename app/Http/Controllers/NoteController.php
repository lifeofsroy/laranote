<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has("searchText") && !is_null($request->searchText)) {
            $notes = Note::where('user_id', auth()->id())->where('title', 'like', '%' . $request->searchText . '%')->paginate(8);
        } else {
            $notes = Note::where('user_id', auth()->id())->paginate(8);
        }

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
            "title" => ['required', 'max:100'],
            "overview" => ['required', 'max:150'],
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
            "title" => ['required', 'max:100'],
            "overview" => ['required', 'max:150'],
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

    public function upload(Request $request): JsonResponse
    {
        if ($request->hasFile('upload')) {
            if ($request->file('upload')->isValid()) {
                $filename = $request->file('upload')->getClientOriginalName();

                $fileName = rand(11111111, 99999999) . "_" . time() . "_" . $filename;
                $fileName = str_replace(' ', '-', $fileName);

                $folder = 'ckeditor/' . date('Y') . '/' . date('m');

                $path = $request->upload->store($folder, 'public');

                return response()->json([
                    'filename' => $filename,
                    'uploaded' => 1,
                    'url' => URL::to('/storage') . '/' . $path
                ]);
            } else {
                return response()->json([
                    'filename' => '',
                    'uploaded' => 0,
                    'url' => ''
                ]);
            }
        }
    }

    public function getFileUrl($file, $mode = '', $width = '', $height = '')
    {
        $fileName = $file->getClientOriginalName();
        $fileName = rand(11111111, 99999999) . "_" . time() . "_" . $fileName;
        $fileName = str_replace(' ', '-', $fileName);

        $folder = 'uploads/' . date('Y') . '/' . date('m');
        $path = base_path($folder);

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        $fileUrl = $folder . '/' . $fileName;
        $image = $file;
        $noExtension = pathinfo($fileName, PATHINFO_FILENAME);

        // check if file is image
        if (substr($image->getMimeType(), 0, 5) == 'image') {
            // if file is not gif
            if ($image->getMimeType() != 'image/gif') {
                $fileName = $noExtension . '.webp';
                $fileUrl = $path . '/' . $fileName;

                if ($mode == 'resize') {
                    Image::make($image)
                        ->resize($width, $height, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })
                        ->encode('webp', 90)
                        ->save($fileUrl);
                } elseif ($mode == 'fit') {
                    Image::make($image)
                        ->fit($width, $height)
                        ->encode('webp', 90)
                        ->save($fileUrl);
                } else {
                    Image::make($image)
                        ->encode('webp', 90)
                        ->save($fileUrl);
                }
            } else {
                $file->move($path, $fileName);
            }
        } else {
            $file->move($path, $fileName);
        }

        $upload_url = url($folder) . '/' . $fileName;
        return $upload_url;
    }
}
