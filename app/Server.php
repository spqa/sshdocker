<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;

class Server extends Model
{
    protected $guarded=[];
    public function vps(){
        return $this->belongsTo(Vps::class,'vps_id');
    }
}
