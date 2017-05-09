<?php

namespace App\Repositories;


use Illuminate\Support\Facades\DB;

class DatabaseRepository
{
    public function create($name)
    {
        DB::connection()->statement('CREATE DATABASE  IF NOT EXISTS ' . $name);
        return true;
    }

    public function drop($name)
    {
        DB::connection()->statement('DROP DATABASE IF EXISTS ' . $name);
        return true;
    }
}