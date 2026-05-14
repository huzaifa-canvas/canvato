<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category_template', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('template_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // Migrate existing category_id data to the pivot table
        $templates = DB::table('templates')->whereNotNull('category_id')->get();
        foreach ($templates as $template) {
            DB::table('category_template')->insert([
                'category_id' => $template->category_id,
                'template_id' => $template->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // We can't easily drop category_id if there are constraints, so we'll just make it nullable or ignore it for now.
        Schema::table('templates', function (Blueprint $table) {
            // Making it nullable so it doesn't fail on inserts
            $table->unsignedBigInteger('category_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_template');
    }
};
