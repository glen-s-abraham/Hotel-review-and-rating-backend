<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CommentReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Comment $comment)
    {
        return $this->showCollectionAsResponse(
            $comment->replies
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Comment $comment)
    {

        if ($request->has('body')) {
            $userId = 1; //replace with auth()->user()->id
            $reply = $comment->replies()->create(
                [
                    'user_id' => $userId,
                    'body' => $request->body
                ]
            );
            return $this->showModelAsResponse($reply);
        }
        throw ValidationException::withMessages(['body' => ['required']]);
    }
}
