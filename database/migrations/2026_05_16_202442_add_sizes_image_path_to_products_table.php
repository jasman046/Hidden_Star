<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Add sizes as JSON (stored as comma-separated fallback)
            $table->json('sizes')->nullable()->after('description');
            // Add image_path for uploaded product photos
            $table->string('image_path')->nullable()->after('sizes');
            // Rename qty to stock for clarity (add stock, keep qty as alias)
            $table->integer('stock')->default(0)->after('qty');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['sizes', 'image_path', 'stock']);
        });
    }
};
