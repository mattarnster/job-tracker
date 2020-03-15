<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Comment;

class CommentController extends Controller
{
    public function store(Request $request) {
        Comment::create($request->all());
        return response('', 204);
    }

    public function delete(Request $request) {
        $comment = Comment::findOrFail($request->id);
        $comment->delete();
        return response('', 204);
    }
}
