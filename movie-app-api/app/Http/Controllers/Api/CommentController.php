<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Movie;
use Illuminate\Http\Request;

/**
 * @group Movie Commenting.
 *
 */
class CommentController extends Controller
{

    /**
     * get all comments.
     * 
     * !Retrieve all comments
     */
    public function index()
    {
        $comment = Comment::whereNull('deleted_at')->get();
        return response()->json(['status' => true, 'data' => $comment]);
    }

    /**
     * Create comment.
     * 
     * @bodyParam movie_id int required The id of the movie. Example: 15
     * @bodyParam user_email string required The email of the user. Example: test1@gmail.com
     * @bodyParam comment string required The comment of the user. Example: This is comment
     * 
     * !anyone can create movie's comments
     */
    public function store(Request $request)
    {
        $request->validate([
            "user_email" => 'required|email:rfc,dns|exists:users,email',
            "comment"  => 'required',
        ]);

        $isMovieIdExist = Movie::find($request->movie_id);
        $comment = "";
        if ($isMovieIdExist) {
            $comment = Comment::create([
                "user_email" => $request->user_email,
                "movie_id" => $request->movie_id,
                "comment"  => $request->comment
            ]);
        }

        if ($comment) {
            return response()->json(["status" => true, "data" => $comment, "message" => 'created successfully'], 200);
        } else {
            return response()->json(["status" => false, "message" => "Invalid input"], 400);
        }
    }
}
