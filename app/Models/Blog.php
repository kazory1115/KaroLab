<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;

    protected $connection = 'mysql'; //連線的資料庫
    protected $table = 'blog'; //連線的資料表

    //設定可填的欄位(用create會需要)
    protected $fillable = [
        'title',
        'content',
        'summary',
        'author_id',
        'category_id',
        'tags',
    ];
}
