<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    use HasUuids;

    protected $table = 'category_posts';
    protected $keyType = 'string';
}
