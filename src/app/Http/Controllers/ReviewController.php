<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use App\Http\Requests\ReviewStoreRequest;
use App\Http\Requests\ReviewUpdateRequest;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->showCollectionAsResponse(Review::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReviewStoreRequest $request)
    {
        $user = User::firstOrFail(); //replace with auth()->user();
        $review = $user->reviews()->create($request->only([
            'hotel_name',
            'review',
            'rating'
        ]));
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/images');
            $review->image()->create(['url' => $path]);
        }
        return $this->showModelAsResponse($review->load('image'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        return $this->showModelAsResponse($review->load('image'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(ReviewUpdateRequest $request, Review $review)
    {
        $review->update($request->only([
            'hotel_name',
            'review',
            'rating'
        ]));
        if ($request->hasFile('image')) {
            if ($review->has('image')) {
                Storage::delete($review->image()->url);
            }
            $path = $request->file('image')->store('public/images');
            $review->image()->create(['url' => $path]);
        }
        return $this->showModelAsResponse($review->load('image'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        if ($review->has('image')) {
            Storage::delete($review->image()->url);
        }
        $review->delete();
        return $this->showModelAsResponse($review);
    }
}
