<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $connection = 'sunfrog';
    protected $guarded = [];
    public $timestamps = false;
    protected $table = 'items';
}
