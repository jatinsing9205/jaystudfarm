<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class reviewsController extends Controller
{
    public function reviews()
    {
        return view('reviews');
    }

    public function loadPendingReviews(Request $request)
    {
        $reviews = DB::table('t_reviews')
            ->where('status', 0)
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($reviews);
    }
    public function loadApprovedReviews(Request $request)
    {
        $reviews = DB::table('t_reviews')
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($reviews);
    }
    public function approveReview(Request $request, $reviewID)
    {
        $updated = DB::table('t_reviews')
            ->where('id', $reviewID)
            ->update(['status' => 1]);

        if ($updated) {
            return response()->json([
                'status' => 'success',
                'message' => 'Review Approved Successfully!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Review could not be approved!'
            ]);
        }
    }
    public function deleteReview(Request $request, $reviewID)
    {
        $deleted = DB::table('t_reviews')->where('id', '=', $reviewID)->delete();

        if ($deleted) {
            return response()->json([
                'status' => 'success',
                'message' => 'Image deleted successfully!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Image could not be deleted!'
            ]);
        }
    }
}
