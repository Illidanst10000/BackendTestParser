<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(type="object"),
 */

class PostCategory extends Model
{

    /**
     *  @OA\Property(
     *      property="post_id",
     *      type="integer",
     *  ),
     *  @OA\Property(
     *      property="category_id",
     *      type="integer",
     *  ),
     */

    use HasFactory;

    protected $table = 'post_categories';
    protected $guarded = false;
}
