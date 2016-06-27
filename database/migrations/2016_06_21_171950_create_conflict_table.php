<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConflictTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conflict', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('name');
            $table->float('lat');
            $table->float('long');
            $table->integer('radius');
            $table->char('conflict_site',255);
            $table->char('conflict_territory',255);
            $table->char('version',255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('conflict');
    }
}
