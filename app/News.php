<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    public function categories(){
        return $this->belongsToMany('App\Category');
    }

    public function user(){
        return $this->belongsTo('App\Models\Auth\User');
    }

    public function getTimeAttribute(){
        $startTime = Carbon::parse($this->created_at);
        $now = Carbon::now();


        return $startTime->diffForHumans($now);
    }
}
