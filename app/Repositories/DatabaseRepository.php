<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 4/24/2017
 * Time: 3:11 PM
 */

namespace App\Repositories;


use Illuminate\Support\Facades\DB;

class DatabaseRepository
{
    public function create($name){
        DB::connection()->statement('CREATE DATABASE  IF NOT EXISTS '.$name);
        return true;
    }

    public function drop($name){
        DB::connection()->statement('DROP DATABASE IF EXISTS '.$name);
        return true;
    }
}