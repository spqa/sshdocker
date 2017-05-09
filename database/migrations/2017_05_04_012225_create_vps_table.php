<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vps',function (Blueprint $table){
            $table->increments('id');
            $table->ipAddress('ip');
            $table->string('password');
            $table->string('username')->nullable();
            $table->integer('port')->nullable();
            $table->string('status')->nullable();
            $table->text('progress')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vps');
    }
}
