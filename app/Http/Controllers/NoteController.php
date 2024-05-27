<?php

namespace App\Http\Controllers;

use App\Models\NoteModel;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function store(Request $request){
        $validate = $request->validate([
            'title' => 'string',
        ]);
        $request['user_id'] = auth()->user()->id;
        $note = NoteModel::create($request->all());
        $success['id'] =  $note->id;
        $success['title'] =  $note->title;
        $success['content'] =  $note->content;
        $success['color'] =  $note->color;
        $success['slug'] =  $note->slug;
        return response()->json([
            'success' => true,
            'message' => 'Note created successfully',
            'data' => $success
        ]);
    }

    public function index(){
        $notes = NoteModel::where('user_id', auth()->user()->id)->get();
        return response()->json([
            'success' => true,
            'message' => 'Notes fetched successfully',
            'data' => $notes
        ]);
    }

    public function show($slug){
        $note = NoteModel::where('user_id', auth()->user()->id)->where('slug', $slug)->FirstOrFail();
        $success['id'] =  $note->id;
        $success['title'] =  $note->title;
        $success['content'] =  $note->content;
        $success['color'] =  $note->color;
        $success['font_color'] =  $note->font_color;
        return response()->json([
            'success' => true,
            'message' => 'Note fetched successfully',
            'data' => $success
        ]);
    }

    public function update(Request $request, $slug){
        $note = NoteModel::where('user_id', auth()->user()->id)->where('slug', $slug)->FirstOrFail();
        $note->update($request->all());
        $success['id'] =  $note->id;
        $success['title'] =  $note->title;
        $success['content'] =  $note->content;
        $success['color'] =  $note->color;
        $success['font_color'] =  $note->font_color;
        $success['slug'] =  $note->slug;
        return response()->json([
            'success' => true,
            'message' => 'Note updated successfully',
            'data' => $success
        ]);
    }

    public function destroy($slug){
        $note = NoteModel::where('user_id', auth()->user()->id)->where('slug', $slug)->FirstOrFail();
        $note->delete();
        return response()->json([
            'success' => true,
            'message' => 'Note deleted successfully',
        ]);
    }

    public function updateIsPinned($slug){
        $note = NoteModel::where('user_id', auth()->user()->id)->where('slug', $slug)->FirstOrFail();
        $note['is_pinned'] = 1;
        $note->save();
        return response()->json([
            'success' => true,
            'message' => 'Note pinned successfully',
            'data' => $note
        ]);
    }
}
