<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServerConnectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_connections', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('connection_name');
            $table->string('connection_method');
            $table->string('hostname');
            $table->integer('port');
            $table->string('username');
            $table->string('password');
            $table->integer('user_id')->unsigned()->index();
            
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('server_connections');
    }
}
