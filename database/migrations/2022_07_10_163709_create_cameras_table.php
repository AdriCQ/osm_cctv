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
        Schema::create('cameras', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('comments')->nullable();
            $table->string('image')->nullable();
            $table->string('ip', 32);
            $table->string('model')->nullable();
            $table->string('brand');
            $table->boolean('dome')->default(false);
            $table->boolean('works')->default(true);
            $table->json('position');
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
        Schema::dropIfExists('cameras');
    }
};
