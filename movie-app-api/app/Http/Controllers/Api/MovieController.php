<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;

/**
 * @group Movie Operations.
 *
 */
class MovieController extends Controller
{
    /**
     * Get all movies.
     *
     * Retrieve all movies
     */
    public function index()
    {
        $movies = Movie::select('id', "title", 'cover_image', 'author', 'imdb_rating')->whereNull('deleted_at')->paginate(5);
        return response()->json(['status' => 'success', 'data' => $movies]);
    }

    /**
     * Creating Movies.
     * 
     * !Just login user can create movies
     * 
     * @bodyParam user_id int required The id of the user. Example: 9
     * @bodyParam title string required The title of the movie. Example: KungFu Panda
     * @bodyParam summary string required The summary of the movie. Example: This is summary of KungFu Panda
     * @bodyParam genres string required The genres of the movie. Example: Action
     * @bodyParam author string required The author of the movie. Example: Person
     * @bodyParam cover_image file The cover images of movie.
     * @bodyParam tags string The tags of the movie. Example: popular
     * @bodyParam imdb_rating int The IMDB rating of the movie. Example: 3
     * @bodyParam pdf_download_link STRING The pdf download link of the movie. Example: popular
     * 
     * @authenticated
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'title' => 'required',
            'summary' => 'required',
            'genres' => 'required',
            'author' => 'required',
            'cover_image' => 'mimes:jpg,bmp,png',
        ]);
        $coverImage = $request->file('cover_image')->store('image');
        $movie = Movie::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'summary' => $request->summary,
            'cover_image' => $coverImage ?? null,
            'genres' => $request->genres,
            'author' => $request->author,
            'tags' => $request->tags ?? "",
            'imdb_rating' => $request->imdb_rating ?? 0,
            'pdf_download_link' => $request->pdf_download_link ?? null,
        ]);

        if ($movie) {
            return response()->json(['status' => true, 'data' => $movie, 'message' => 'created successfully'], 200);
        } else {
            return response()->json(['status' => false, 'message' => "Invalid input"], 400);
        }
    }

    /**
     * Show movie details.
     * 
     * you can look the detail information about movies
     */
    public function show(string $movieId)
    {
        $movie = Movie::find($movieId);
        if ($movie) {
            $relatedMovies = Movie::where('author', $movie->author)->orWhere('genres', $movie->genres)->orWhere('tags', $movie->tags)->orWhere('imdb_rating', $movie->imdb_rating)->get();
            $movie["comment"] = $movie->comment;
            $movie["relatedMovies"] = collect($relatedMovies)->where('id', "!=", $movieId);
            return response()->json(['status' => true, 'data' => $movie, 'message' => 'retrieved successfully'], 200);
        } else {
            return response()->json(["status" => false, 'message' => 'There is no data related to request movie id'], 404);
        }
    }

    /**
     * Edit movies.
     * 
     * !to edit movies you have to login.
     * 
     * @bodyParam user_id int required The id of the user. Example: 9
     * @bodyParam title string required The title of the movie. Example: KungFu Panda
     * @bodyParam summary string required The summary of the movie. Example: This is summary of KungFu Panda
     * @bodyParam genres string required The genres of the movie. Example: Action
     * @bodyParam author string required The author of the movie. Example: Person
     * @bodyParam cover_image file The cover images of movie.
     * @bodyParam tags string The tags of the movie. Example: popular
     * @bodyParam imdb_rating int The IMDB rating of the movie. Example: 3
     * @bodyParam pdf_download_link STRING The pdf download link of the movie. Example: popular
     * 
     * @authenticated
     */
    public function update(Request $request, string $movieId)
    {
        $request->validate([
            'title' => 'string',
            'summary' => 'string',
            'genres' => 'string',
            'author' => 'string',
        ]);

        $movie = Movie::find($movieId);
        if ($movie) {
            $movie->title = $request->title ?? $movie->title;
            $movie->summary = $request->summary ?? $movie->summary;
            $movie->cover_image = $request->cover_image ?? $movie->cover_image;
            $movie->genres = $request->genres ?? $movie->genres;
            $movie->author = $request->author ?? $movie->author;
            $movie->tags = $request->tags ?? $movie->tags;
            $movie->imdb_rating = $request->imdb_rating ?? $movie->imdb_rating;
            $movie->pdf_download_link = $request->pdf_download_link ?? $movie->pdf_download_link;
            $movie->related_movies = $request->related_movies ?? $movie->related_movies;
            $movie->save();
            return response()->json(['status' => true, 'data' => $movie, 'message' => 'updated successfully'], 200);
        } else {
            return response()->json(["status" => false, 'message' => 'There is no data related to request movie id'], 404);
        }
    }

    /**
     * Delete movies.
     * 
     * !to delete movies you have to login.
     * 
     * @authenticated
     */
    public function destroy(string $movieId)
    {
        $movie = Movie::find($movieId);
        if ($movie) {
            $isDeleted = $movie->delete();
            return response()->json(['status' => $isDeleted, 'message' => $movie->title . ' is deleted successfully'], 200);
        } else {
            return response()->json(["status" => false, 'message' => 'There is no data related to request movie id'], 404);
        }
    }
}
