<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Models\Post;

class APIController extends BaseController
{
    /**
     * @OA\Get(
     *     path="/posts",
     *     operationId="postsAll",
     *     tags={"Posts"},
     *     summary="Get list of posts",
     *     description="Get Post",
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *
     *     @OA\JsonContent()
     *     ),
     * )
     *
     *
     */

    public function index()
    {
        $postCollection = Post::all();
        $posts = $this->service->showAllPosts($postCollection);

        return response()->json($posts, 200);
    }

    /**
     * @OA\Post(
     * path="/posts",
     * operationId="postCreate",
     * summary="Create Post",
     * tags={"Posts"},
     * description="Create Post",
     *     @OA\RequestBody(
     *     description="pubDate format: D, d M Y H:i:s O",

     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"title", "link", "description", "pubDate", "guid"},
     *
     *               @OA\Property(property="title", type="string", example="Example title"),
     *               @OA\Property(property="link", type="string", example="google.com"),
     *               @OA\Property(property="description", type="string", example="Example description"),
     *               @OA\Property(property="pubDate", type="date", example="Sat, 03 Dec 2022 16:30:00 +0000"),
     *               @OA\Property(property="category", type="array", @OA\Items(), example="[""Ford"", ""BMW"", ""Audi""]"),
     *               @OA\Property(property="guid", type="string", example="184986510"),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=201,
     *          description="Created Successfully",
     *          @OA\JsonContent()
     *       )
     * )
     */

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $this->service->store($data);

        return response()->json(201);
    }

    /**
     * @OA\Put (
     * path="/posts/{id}",
     * operationId="postUpdate",
     * summary="Update Post",
     * tags={"Posts"},
     * description="Update Post by ID",
     *     @OA\Parameter (
     *          name="id",
     *          in="path",
     *          description="Post ID",
     *          required=true,
     *            @OA\Schema(
     *               type="integer",
     *               required={"id"},
     *        ),
     *     ),
     *     @OA\RequestBody(
     *     description="pubDate format: D, d M Y H:i:s O",
     *            @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *
     *               @OA\Property(property="title", type="string", example="Example title"),
     *               @OA\Property(property="link", type="string", example="google.com"),
     *               @OA\Property(property="description", type="string", example="Example description"),
     *               @OA\Property(property="pubDate", type="date", example="Sat, 03 Dec 2022 16:30:00 +0000"),
     *               @OA\Property(property="category", type="array", @OA\Items(), example="[""Ford"", ""BMW"", ""Audi""]"),
     *               @OA\Property(property="guid", type="string", example="184986510"),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=201,
     *          description="Created Successfully",
     *          @OA\JsonContent()
     *       ),
     * )
     */

    public function update(UpdateRequest $request, Post $post)
    {
        $data = $request->validated();
        $this->service->update($data, $post);

        return response()->json(201);
    }

    /**
     * @OA\Delete (
     * path="/posts/{id}",
     * operationId="postDelete",
     * summary="Delete Post",
     * tags={"Posts"},
     * description="Delete post by ID",
     *
     *     @OA\Parameter (
     *          name="id",
     *          in="path",
     *          description="Post ID",
     *          required=true,
     *            @OA\Schema(
     *               type="integer",
     *               required={"id"},
     *        ),
     *     ),
     *      @OA\Response(
     *          response=204,
     *          description="Deleted Successfully",
     *          @OA\JsonContent()
     *       ),
     * )
     *
     *
     */

    public function destroy(Post $post)
    {
        $this->service->destroy($post);

        return response()->json(201);
    }

    /**
     * @OA\Get(
     *     path="/posts/{id}",
     *     summary="Get post by id",
     *     tags={"Posts"},
     *     description="Get post by id",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Post id",
     *         required=true,
     *              @OA\Schema(
     *               type="integer",
     *               required={"id"},
     *        ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent()
     *     ),
     * )
     *
     *
     */

    public function show(Post $post)
    {
        $post = $this->service->show($post);

        return response()->json($post, 200);
    }


}
