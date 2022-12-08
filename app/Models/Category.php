<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(type="object"),
 */

class Category extends Model
{
    /**
     *  @OA\Property(
     *      property="title",
     *      type="string",
     *  ),
     */

    use HasFactory;

    protected $table = 'categories';
    protected $guarded = false;
}
