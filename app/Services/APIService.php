<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class ParserService
{
    public function parse($data)
    {
        try {
            DB::beginTransaction();

            foreach ($data->channel->item as $item)
            {
                $postData = (array)$item;

                if (isset($postData['category'])) {
                    $categories = $postData['category'];
                    unset($postData['category']);
                }

                $postData['pubDate'] = $this->createDateObject($postData['pubDate']);

                $post = Post::firstOrCreate($postData);

                if (isset($categories)) {
                    $categoryIds = $this->createCategory($categories);
                    $post->categories()->attach($categoryIds);
                }
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            abort(500);
        }
    }

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

    public function update()
    {

    }

    public function delete()
    {

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
