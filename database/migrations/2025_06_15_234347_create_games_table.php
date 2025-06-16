<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('games', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->enum('status', ['waiting', 'active', 'finished'])->default('waiting');
    $table->integer('current_turn')->nullable();
    $table->integer('winner_id')->nullable();
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
        Schema::dropIfExists('games');
    }
};
