<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'level')) {
                $table->string('level')->nullable();
            }
            if (!Schema::hasColumn('courses', 'objectives')) {
                $table->text('objectives')->nullable();
            }
            if (!Schema::hasColumn('courses', 'requirements')) {
                $table->text('requirements')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['level', 'objectives', 'requirements']);
        });
    }
};