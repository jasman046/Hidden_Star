<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_contents', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();          // e.g. 'hero_banner', 'gallery_1' …
            $table->string('label');                  // Human-readable label for admin UI
            $table->string('image_path')->nullable(); // Relative path under storage/public
            $table->string('group')->default('home'); // 'home', 'about', 'gallery'
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_contents');
    }
};
