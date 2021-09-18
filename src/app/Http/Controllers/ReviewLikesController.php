<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Log;

class ReviewLikesController extends Controller
{
    public function index(Review $review)
    {
        return $this->successResponse(
            $review->likes()->count(),
            200
        );
    }

    public function toggleReviewLike(Review $review)
    {
        $userId = 1; //replace with auth()->user()->id;
        if (
            $review->likes()
            ->where('user_id', $userId)
            ->count() != 0
        ) {
            $review->likes()
                ->where('user_id', $userId)->delete();
            return $this->successResponse('unliked', 200);
        } else {
            $review->likes()->create(['user_id' => $userId]);
            return $this->successResponse('liked', 200);
        }
    }
}
