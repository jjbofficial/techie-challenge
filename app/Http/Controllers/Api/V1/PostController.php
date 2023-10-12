<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StorePostRequest;
use App\Http\Requests\Api\V1\UpdatePostRequest;
use App\Http\Resources\Api\V1\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    /**
     * View all posts
     */
    public function index()
    {
        $user = auth()->user();

        return PostResource::collection(
            $user->posts()->paginate(8)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $user = auth()->user();

        $user->posts()->create([
            $request->safe()
                ->merge([
                    'slug' => str($request->title)->slug()
                ])
                ->toArray()
        ]);

        return response(status: Response::HTTP_CREATED);
    }

    /**
     * View a single post
     */
    public function show(string $id)
    {
        $post = Post::with('author')
            ->findOrFail($id);

        $this->authorize('view', $post);

        return PostResource::make($post);
    }

    /**
     * Edit a post
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update([
            $request->safe()
                ->merge([
                    'slug' => str($request->title)->slug()
                ])
                ->toArray()
        ]);

        return response(status:Response::HTTP_OK);
    }

    /**
     * Delete a post
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return response(status:Response::HTTP_OK);
    }
}
