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
       Schema::create('ships', function (Blueprint $table) {
    $table->id();
    $table->foreignId('board_id')->constrained()->onDelete('cascade');
    $table->string('position'); // formato 'a1', 'b3', etc.
    $table->boolean('hit')->default(false);
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
        Schema::dropIfExists('ships');
    }
};
