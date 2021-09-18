<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class ReviewCommentController extends Controller
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
    public function index(Review $review)
    {
        return $this->showCollectionAsResponse(
            $review->comments
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Review $review)
    {
        if ($request->has('body')) {
            $userId = 1; //replace with auth()->user()->id
            $comment = $review->comments()->create(
                [
                    'body' => $request->body,
                    'user_id' => $userId
                ]
            );
            return $this->showModelAsResponse($comment);
        }
        throw ValidationException::withMessages(['body' => ['required']]);
    }
}
