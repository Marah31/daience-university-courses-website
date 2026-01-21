<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('ref_code')->unique();
            $table->string('duration');
            $table->text('description');
            $table->text('about_course')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('category')->nullable();
            $table->timestamps();
        });
    }


public function down(): void
{
    Schema::table('courses', function (Blueprint $table) {
        $table->dropColumn(['ref_code', 'duration', 'about_course', 'category']);
    });
}

};
