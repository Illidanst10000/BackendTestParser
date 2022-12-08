<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Support\Facades\DB;

class APIService
{

    public function store($data)
    {
        try {
            DB::beginTransaction();

            if (isset($data['categories'])) {
                $categories = $data['categories'];
                unset($data['categories']);
            }

            $data['pubDate'] = $this->createDateObject($data['pubDate']);

            $post = Post::firstOrCreate($data);

            if (isset($categories)) {

                $categoryIds = $this->createCategory($categories);
                $post->categories()->attach($categoryIds);
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            abort(500);
        }
    }

    public function update($data, $post)
    {
        try {
            DB::beginTransaction();

            if (isset($data['categories'])) {
                $categories = $data['categories'];
                unset($data['categories']);
            }

            $data['pubDate'] = $this->createDateObject($data['pubDate']);

            $post->update($data);

            if (isset($categories)) {
                $categoryIds = $this->createCategory($categories);
                $post->categories()->sync($categoryIds);
            }
            else (
                $post->categories()->delete()
            );

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            abort(500);
        }
    }

    public function destroy($post)
    {
        $post->delete();
        $post->categories()->delete($post->id);
    }

    public function show($post)
    {
        $post['pubDate'] = $this->createDBDateObject($post['pubDate']);
        $post['pubDate'] = date_format($post['pubDate'], env('FORMAT_DATE'));

        return $post;
    }

    public function showAllPosts($postsCollection)
    {
        $posts = [];

        foreach ($postsCollection as $post)
        {
            $post = $post->toArray();

            $post['pubDate'] = $this->createDBDateObject($post['pubDate']);
            $post['pubDate'] = date_format($post['pubDate'], env('FORMAT_DATE'));

            array_push($posts, $post);
        }

        return $posts;
    }

    public function createDateObject($date)
    {
        return (new \DateTime())
            ->createFromFormat(env('FORMAT_DATE'), $date);
    }

    public function createDBDateObject($date)
    {
        return (new \DateTime())
            ->createFromFormat('Y-m-d H:i:s', $date);
    }

    public function createCategory($categories)
    {
        $categoryIds = [];

        foreach ($categories as $category) {
            $category = Category::firstOrCreate(['title' => $category]);
            array_push($categoryIds, $category->id);
        }

        return $categoryIds;
    }
}
