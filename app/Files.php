<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    protected $table = 'files';
    protected $fillable = ['id', 'user_id', 'news_id', 'path', 'file', 'file_name', 'size'];
}
