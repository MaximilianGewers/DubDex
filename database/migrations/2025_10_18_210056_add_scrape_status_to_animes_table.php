<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::table('animes', function (Blueprint $table) {
        $table->string('scrape_status')->default('needs_data')->nullable(false)->index();
    });
}

public function down(): void
{
    Schema::table('animes', function (Blueprint $table) {
        $table->dropColumn('scrape_status');
    });
}
};
