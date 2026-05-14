<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->string('type')->nullable()->after('category_id');
            $table->string('color_space')->nullable()->after('meta_data');
            $table->string('orientation')->nullable()->after('color_space');
            $table->json('properties')->nullable()->after('orientation');
            $table->json('compatible_tools')->nullable()->after('properties');
        });
    }

    public function down(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->dropColumn(['type', 'color_space', 'orientation', 'properties', 'compatible_tools']);
        });
    }
};
