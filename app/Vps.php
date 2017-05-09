<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vps extends Model
{
    protected $table='vps';
    protected $guarded=[];

    public function servers(){
        return $this->hasMany(Server::class);
    }
}
