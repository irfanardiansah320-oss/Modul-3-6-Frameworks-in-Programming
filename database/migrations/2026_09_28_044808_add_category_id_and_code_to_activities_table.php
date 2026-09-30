<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->foreignId('category_id')->after('id')->constrained()->restrictOnDelete();
            $table->string('code', 30)->unique()->after('category_id');
            $table->dropColumn('category');
        });
    }

    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['category_id', 'code']);
            $table->string('category')->nullable();
        });
    }
};