<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
    Schema::create('contents', function (Blueprint $table) {
        $table->id();
        $table->string('page');    // home, about, dll
        $table->string('section'); // hero, stats, dll
        $table->string('key');     // title, sub_title, img_url
        $table->text('value')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
