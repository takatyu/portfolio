<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    //モデルクラスにおけるリレーション
    public function tasks() {
        return $this->hasMany('App\Task');
    }
}
