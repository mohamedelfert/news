<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';

    protected $fillable = ['id','user_id','title','desc','content','photo'];

    public function getUserName(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function files(){
        return $this->hasMany(Files::class,'news_id','id');
    }
}
